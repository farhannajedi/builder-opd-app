<?php

namespace App\Observers;

use App\Models\Opd;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class OpdObserver
{
    // buat child web saat buat opd
    public function created(Opd $opd): void
    {
        $slug = $opd->slug;

        // Load configs
        $rootPath = config('opd.root_path', realpath(base_path('..')));
        $masterPath = config('opd.template_path', base_path('master-opd'));
        $corePublicPath = config('opd.core_public_path', base_path('public'));
        $coreStoragePath = config('opd.core_storage_path', storage_path('app/public'));

        $newProjectPath = $rootPath . DIRECTORY_SEPARATOR . $slug;

        // buat folder proyek baru jika belum ada
        if (!File::isDirectory($newProjectPath)) {
            Log::info("Membuat folder child web: {$newProjectPath}");

            File::makeDirectory($newProjectPath . DIRECTORY_SEPARATOR . 'public', 0755, true);
            File::makeDirectory($newProjectPath . DIRECTORY_SEPARATOR . 'bootstrap', 0755, true);

            // Salin file dari folder master-opd 
            if (File::isDirectory($masterPath)) {
                Log::info("Copy file dari master: {$masterPath}");

                // Copy file penting dari master folder di folder core
                File::copy($masterPath . '/public/index.php', $newProjectPath . '/public/index.php');
                File::copy($masterPath . '/public/.htaccess', $newProjectPath . '/public/.htaccess');
                File::copy($masterPath . '/bootstrap/app.php', $newProjectPath . '/bootstrap/app.php');

                Log::info("File master berhasil di-copy");
            } else {
                Log::error("Folder master tidak ditemukan: {$masterPath}");
                return;
            }

            // Membuat file .env khusus untuk identitas web child
            $env = "APP_NAME=\"" . $opd->name . "\"\n" .
                "APP_ID=\"" . $slug . "\"\n" .
                "APP_ENV=local\n" .
                "APP_DEBUG=true\n" .
                "APP_URL=\"http://" . $slug . ".test\"\n";
            File::put($newProjectPath . '/.env', $env);

            Log::info(".env berhasil dibuat");

            // Memanggil createSymlinks agar folder 'build' ikut terbuat
            // Manifest.json akan diambil dari core app utama symlink
            $this->createSymlinks($newProjectPath, $corePublicPath, $coreStoragePath);

            Log::info("Child website berhasil dibuat untuk OPD: {$slug}");
        } else {
            Log::warning("Folder child app {$slug} sudah ada, proses pembuatan dilewatkan.");
        }
    }

    // membuat Symlink (Storage & Build Vite)
    // yg manifest.json diambil dari core app utama (web-builder-app/public/build/)
    protected function createSymlinks($projectPath, $corePublicPath, $coreStoragePath)
    {
        $targetPublic = $projectPath . DIRECTORY_SEPARATOR . 'public';

        // daftar folder yang di link 
        $foldersToLink = [
            'storage' => $coreStoragePath,
            'build'   => $corePublicPath . DIRECTORY_SEPARATOR . 'build', // Manifest.json ada di sini
        ];

        foreach ($foldersToLink as $linkName => $targetPath) {
            $shortcutPath = $targetPublic . DIRECTORY_SEPARATOR . $linkName;

            // folder target di induk folder ada sebelum di link
            if (!File::isDirectory($targetPath)) {
                Log::warning("Gagal membuat symlink: Folder target {$targetPath} tidak ditemukan.");
                continue;
            }

            // hapus jika link lama sudah ada 
            if (file_exists($shortcutPath)) {
                $this->removeSymlink($shortcutPath);
            }

            // buat Symlink 
            if (PHP_OS_FAMILY === 'Windows') {
                exec("mklink /D \"$shortcutPath\" \"$targetPath\" 2>&1", $output, $return);
                if ($return === 0) {
                    Log::info("Symlink {$linkName} berhasil dibuat");
                } else {
                    Log::error("Gagal membuat symlink {$linkName}: " . implode("\n", $output));
                }
            } else {
                if (symlink($targetPath, $shortcutPath)) {
                    Log::info("Symlink {$linkName} berhasil dibuat");
                } else {
                    Log::error("Gagal membuat symlink {$linkName}");
                }
            }
        }
    }

    // hapus symlink
    protected function removeSymlink($path)
    {
        if (file_exists($path)) {
            if (PHP_OS_FAMILY === 'Windows') {
                exec("rmdir \"$path\"");
            } else {
                unlink($path);
            }
        }
    }

    // hapus opd
    public function deleted(Opd $opd): void
    {
        $this->removeFolder($opd);
    }

    // hapus opd secara permanen 
    public function forceDeleted(Opd $opd): void
    {
        $this->removeFolder($opd);
    }

    // hapus dolder fisikny
    protected function removeFolder(Opd $opd)
    {
        $slug = $opd->slug;
        if (empty($slug)) {
            Log::error("Gagal menghapus folder: Slug OPD kosong.");
            return;
        }

        // load configny
        $rootPath = config('opd.root_path', realpath(base_path('..')));
        $projectPath = $rootPath . DIRECTORY_SEPARATOR . $slug;

        Log::info("Menghapus folder child web: {$projectPath}");

        if (File::isDirectory($projectPath)) {
            try {
                // hapus symlink dulu agar folder bisa dihapus bersih di foldernya
                $this->removeSymlinks($projectPath);
                File::deleteDirectory($projectPath);

                Log::info("Berhasil menghapus folder proyek: {$slug}");
            } catch (\Exception $e) {
                Log::error("Gagal menghapus folder proyek {$slug}: " . $e->getMessage());
            }
        } else {
            Log::warning("Folder child web tidak ditemukan: {$projectPath}");
        }
    }

    // jika ingin dihapus bersihkan symlinkny
    protected function removeSymlinks($projectPath)
    {
        $publicPath = $projectPath . DIRECTORY_SEPARATOR . 'public';
        $links = ['storage', 'build'];

        foreach ($links as $link) {
            $target = $publicPath . DIRECTORY_SEPARATOR . $link;
            $this->removeSymlink($target);
        }
    }

    public function updated(Opd $opd): void {}
    public function restored(Opd $opd): void {}
}

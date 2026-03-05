<?php

namespace App\Observers;

use App\Models\Opd;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class OpdObserver
{

    protected function ensureMasterBuildSymlink(): void
    {
        $masterPublic = base_path('master-opd/public');
        $targetBuild = base_path('public/build');
        $link = $masterPublic . '/build';

        if (!file_exists($targetBuild)) {
            Log::error("Build master belum ada. Jalankan npm run build dulu.");
            return;
        }

        if (!file_exists($link)) {

            if (PHP_OS_FAMILY === 'Windows') {
                exec("mklink /D \"$link\" \"$targetBuild\"");
            } else {
                symlink($targetBuild, $link);
            }

            Log::info("Symlink build master-opd berhasil dibuat.");
        }
    }

    // buat folder website child web OPD
    public function created(Opd $opd): void
    {
        $slug = $opd->slug;

        if (empty($slug)) {
            Log::error("Slug OPD kosong, gagal membuat child web.");
            return;
        }

        $basePath = realpath(base_path('../'));
        $projectPath = $basePath . DIRECTORY_SEPARATOR . $slug;
        $masterPath = base_path('master-opd');

        // buat struktur folder child web OPD jika belum ada
        if (!File::isDirectory($projectPath)) {

            File::makeDirectory($projectPath . '/public', 0755, true);
            File::makeDirectory($projectPath . '/bootstrap', 0755, true);

            //   copy file core dari master-opd
            if (File::isDirectory($masterPath)) {

                File::copy(
                    $masterPath . '/public/index.php',
                    $projectPath . '/public/index.php'
                );

                File::copy(
                    $masterPath . '/public/.htaccess',
                    $projectPath . '/public/.htaccess'
                );

                File::copy(
                    $masterPath . '/bootstrap/app.php',
                    $projectPath . '/bootstrap/app.php'
                );
            }

            //    buat file .env di web folder chil nya
            $env = "APP_NAME=\"" . $opd->name . "\"\n" .
                "APP_ID=\"" . $slug . "\"\n" .
                "APP_ENV=local\n" .
                "APP_DEBUG=true\n" .
                "APP_URL=\"http://" . $opd->domain . ".test\"\n";

            File::put($projectPath . '/.env', $env);

            // membuat symlink asset storage
            $this->createSymlinks($projectPath);

            // create file build di folder master-opd
            $this->ensureMasterBuildSymlink();

            Log::info("Child website berhasil dibuat untuk OPD: {$slug}");
        }
    }

    protected function createSymlinks(string $projectPath): void
    {
        $corePublicPath = public_path();
        $coreStoragePath = storage_path('app/public');
        $targetPublic = $projectPath . DIRECTORY_SEPARATOR . 'public';

        // Daftar Folder yang harus di link
        $folders = [
            'storage' => $coreStoragePath,
            'build'   => $corePublicPath . DIRECTORY_SEPARATOR . 'build',
            'images'  => $corePublicPath . DIRECTORY_SEPARATOR . 'images',
        ];

        foreach ($folders as $name => $target) {
            $linkPath = $targetPublic . DIRECTORY_SEPARATOR . $name;
            $this->safeSymlink($target, $linkPath, true);
        }

        // Daftar File satuan yang harus di link
        $files = [
            'logo_kab.png' => $corePublicPath . DIRECTORY_SEPARATOR . 'logo_kab.png',
        ];

        foreach ($files as $name => $target) {
            $linkPath = $targetPublic . DIRECTORY_SEPARATOR . $name;
            $this->safeSymlink($target, $linkPath, false);
        }
    }

    protected function safeSymlink(string $target, string $link, bool $isDir): void
    {
        if (!file_exists($target)) return;

        // Hapus link lama jika ada agar tidak konflik
        if (file_exists($link) || is_link($link)) {
            PHP_OS_FAMILY === 'Windows'
                ? exec($isDir ? "rmdir /S /Q \"$link\"" : "del /F /Q \"$link\"")
                : unlink($link);
        }

        if (PHP_OS_FAMILY === 'Windows') {
            $mode = $isDir ? '/D' : '';
            // Jalankan perintah mklink
            exec("mklink $mode \"$link\" \"$target\"");
        } else {
            symlink($target, $link);
        }
    }

    // hapus folder child web OPD
    public function deleted(Opd $opd): void
    {
        $this->removeFolder($opd);
    }

    // hapus folder child web OPD
    protected function removeFolder(Opd $opd): void
    {
        $slug = $opd->slug;

        if (empty($slug)) return;

        $basePath = realpath(base_path('../'));
        $projectPath = $basePath . DIRECTORY_SEPARATOR . $slug;
        $domain = $opd->domain . ".test";

        if (File::isDirectory($projectPath)) {
            try {
                $this->removeSymlinks($projectPath);
                File::deleteDirectory($projectPath);

                Log::info("Folder child web berhasil dihapus: {$slug}");
            } catch (\Exception $e) {
                Log::error("Gagal hapus folder {$slug}: " . $e->getMessage());
            }
        }
    }

    //    hapus symslinknya 
    protected function removeSymlinks(string $projectPath): void
    {
        $links = ['storage', 'build'];

        foreach ($links as $link) {
            $target = $projectPath . '/public/' . $link;

            if (file_exists($target) || is_link($target)) {
                if (PHP_OS_FAMILY === 'Windows') {
                    exec("rmdir \"$target\"");
                } else {
                    unlink($target);
                }
            }
        }
    }

    public function updated(Opd $opd): void {}
    public function restored(Opd $opd): void {}
}

<?php

namespace App\Observers;

use App\Models\Opd;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

class OpdObserver
{
    /**
     * observer digunakan sebagai pembuatan folder otomatis build folder
     * Setelah data OPD berhasil disimpan ke database
     */
    public function created(Opd $opd): void
    {
        $slug = $opd->slug;
        $basePath = realpath(base_path('../'));
        $newProjectPath = $basePath . DIRECTORY_SEPARATOR . $slug;
        $masterPath = $basePath . DIRECTORY_SEPARATOR . 'master-opd';

        // membuat folder proyek baru jika belum ada
        if (!File::isDirectory($newProjectPath)) {
            File::makeDirectory($newProjectPath . '/public', 0755, true);
            File::makeDirectory($newProjectPath . '/bootstrap', 0755, true);

            // Salin file jembatan dari folder master-opd
            if (File::isDirectory($masterPath)) {
                File::copy($masterPath . '/public/index.php', $newProjectPath . '/public/index.php');
                File::copy($masterPath . '/public/.htaccess', $newProjectPath . '/public/.htaccess');
                File::copy($masterPath . '/bootstrap/app.php', $newProjectPath . '/bootstrap/app.php');
            }

            // Buat file .env khusus untuk identitas web child
            $env = "APP_NAME=\"" . $opd->name . "\"\n" .
                "APP_ID=\"" . $slug . "\"\n" .
                "APP_ENV=local\n" .
                "APP_DEBUG=true\n" .
                "APP_URL=\"http://" . $slug . ".test\"\n";
            File::put($newProjectPath . '/.env', $env);

            // memanggil createSymlinks agar folder 'build' (Vite) ikut terbuat
            $this->createSymlinks($newProjectPath);
        }
    }

    /**
     * Helper untuk membuat Symlink Lengkap (Storage & Build Vite)
     */
    protected function createSymlinks($projectPath)
    {
        $corePublicPath = base_path('public');

        // Daftar folder yang harus di-link ke pusat
        $foldersToLink = [
            'storage' => base_path('storage/app/public'),
            'build'   => $corePublicPath . DIRECTORY_SEPARATOR . 'build',
        ];

        foreach ($foldersToLink as $linkName => $targetPath) {
            $shortcutPath = $projectPath . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . $linkName;

            // Pastikan folder target di induk folder ada sebelum di-link
            if (!File::isDirectory($targetPath)) {
                Log::warning("Gagal membuat symlink: Folder target {$targetPath} tidak ditemukan. Pastikan sudah menjalankan 'npm run build'.");
                continue;
            }

            // Hapus jika link lama sudah ada (untuk refresh)
            if (file_exists($shortcutPath)) {
                PHP_OS_FAMILY === 'Windows' ? exec("rmdir \"$shortcutPath\"") : unlink($shortcutPath);
            }

            // Buat Symlink berdasarkan Sistem Operasi
            if (PHP_OS_FAMILY === 'Windows') {
                exec("mklink /D \"$shortcutPath\" \"$targetPath\"");
            } else {
                symlink($targetPath, $shortcutPath);
            }
        }
    }

    /**
     * Kejadian: Saat data OPD dihapus (Normal Delete)
     */
    public function deleted(Opd $opd): void
    {
        $this->removeFolder($opd);
    }

    /**
     * Kejadian: Saat data OPD dihapus permanen (Force Delete)
     */
    public function forceDeleted(Opd $opd): void
    {
        $this->removeFolder($opd);
    }

    /**
     * Helper untuk menghapus folder proyek anak
     */
    protected function removeFolder(Opd $opd)
    {
        $slug = $opd->slug;
        $basePath = realpath(base_path('../'));
        $projectPath = $basePath . DIRECTORY_SEPARATOR . $slug;

        if (File::isDirectory($projectPath)) {
            try {
                // Hapus symlink dulu agar folder bisa dihapus bersih di Windows
                $this->removeSymlinks($projectPath);
                File::deleteDirectory($projectPath);

                Log::info("Berhasil menghapus folder proyek: " . $slug);
            } catch (\Exception $e) {
                Log::error("Gagal menghapus folder proyek {$slug}: " . $e->getMessage());
            }
        }
    }

    /**
     * Helper untuk membersihkan Symlink sebelum hapus folder
     */
    protected function removeSymlinks($projectPath)
    {
        $publicPath = $projectPath . DIRECTORY_SEPARATOR . 'public';
        $links = ['storage', 'build'];

        foreach ($links as $link) {
            $target = $publicPath . DIRECTORY_SEPARATOR . $link;
            if (file_exists($target)) {
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

<?php

namespace App\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;
use Laravel\Folio\Folio;

class ChildAppFolioServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Jalankan hanya jika Folio di-load (yaitu, dalam konteks HTTP)
        if (class_exists(Folio::class) && App::runningInConsole() === false) {

            // Dapatkan Base Path yang sudah di-override (web-builder-app)
            $basePath = $this->app->basePath();

            // Tentukan path ke folder views Folio
            $folioPath = $basePath . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'pages';

            // Registrasikan path ke Folio Manager
            if (is_dir($folioPath)) {
                Folio::path($folioPath);
                // Tambahkan middleware global Folio di sini jika ada
            }
        }
    }
}

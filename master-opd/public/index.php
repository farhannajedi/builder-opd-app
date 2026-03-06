<?php

use Dotenv\Dotenv;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Vite;

// path web child
$childPublicPath = __DIR__;
$childRootPath = dirname($childPublicPath);
$coreAppPath = realpath($childPublicPath . '/../../web-builder-app');

// autoload dari Core
require $coreAppPath . '/vendor/autoload.php';

// load .env Child webnya
if (file_exists($childRootPath . '/.env')) {
    $dotenv = Dotenv::createImmutable($childRootPath);
    $dotenv->load();
}

// booting Laravel
$app = require $childRootPath . '/bootstrap/app.php';

// Set Base Path ke Core, tapi Public Path ke Child
$app->setBasePath($coreAppPath);
$app->usePublicPath($childPublicPath);

Facade::setFacadeApplication($app);

// Konfigurasi Vite
$app->booting(function () use ($childPublicPath) {
    // paksa Vite mencari manifest secara absolut.
    // laravel mencari di public_path(build/manifest.json)
    // symlink 'build' di folder child mengarah ke core/public/build
    Vite::useBuildDirectory('build');
    Vite::useManifestFilename('.vite/manifest.json');

    // pastikan Hot Reloading tidak kacau di local
    if (file_exists($childPublicPath . '/hot')) {
        unlink($childPublicPath . '/hot');
    }

    // Registrasi Folio Pages dari Master webny
    $coreAppPath = realpath($childPublicPath . '/../../web-builder-app');
    $folioPath = $coreAppPath . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'pages';
    if (class_exists(\Laravel\Folio\Folio::class) && is_dir($folioPath)) {
        \Laravel\Folio\Folio::path($folioPath);
    }
});

// jalankan Aplikasi
$kernel = $app->make(Kernel::class);
$response = $kernel->handle($request = Request::capture());
$response->send();
$kernel->terminate($request, $response);

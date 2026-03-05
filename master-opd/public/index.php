<?php

use Dotenv\Dotenv;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Vite;

// path menuju msaster-opd di web utamanya
$coreAppPath = realpath(__DIR__ . '/../../web-builder-app');
require $coreAppPath . '/vendor/autoload.php';

// load file .env
if (file_exists(dirname(__DIR__) . '/.env')) {
    $dotenv = Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();
}

// booting laravel
$app = require dirname(__DIR__) . '/bootstrap/app.php';
$app->setBasePath($coreAppPath);
$app->usePublicPath(__DIR__);

Facade::setFacadeApplication($app);

// vite
$app->booting(function () use ($app, $coreAppPath) {
    // Paksa Vite mencari di folder 'build' milik child
    Vite::useBuildDirectory('build');

    // Gunakan nama file saja Laravel akan menggabungnya dengan public_path(__DIR__)
    Vite::useManifestFilename('manifest.json');

    // Registrasi Folio Pages dari Master
    $folioPath = $coreAppPath . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'pages';
    if (class_exists(\Laravel\Folio\Folio::class) && is_dir($folioPath)) {
        \Laravel\Folio\Folio::path($folioPath);
    }
});

// menjalankan Aplikasi
$kernel = $app->make(Kernel::class);
$response = $kernel->handle($request = Request::capture());
$response->send();
$kernel->terminate($request, $response);

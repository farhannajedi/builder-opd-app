<?php

use Dotenv\Dotenv;
use Illuminate\Http\Request;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Vite;

// Path Absolut ke Aplikasi Pusat
$coreAppPath = realpath(__DIR__ . '/../../web-builder-app');
require $coreAppPath . '/vendor/autoload.php';

// Load .env dari folder anak
if (file_exists(dirname(__DIR__) . '/.env')) {
    $dotenv = Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();
}

// Set Path Inti
putenv('CHILD_PROJECT_PATH=' . $coreAppPath);

// Boot Aplikasi
$app = require_once dirname(__DIR__) . '/bootstrap/app.php';

// Atur Path & Facade
$app->setBasePath($coreAppPath);
$app->usePublicPath(realpath(__DIR__));
Facade::setFacadeApplication($app);

// Memaksa Vite mencari manifest di folder pusat
$manifestPath = $coreAppPath . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'build';
Vite::useManifestFilename($manifestPath . DIRECTORY_SEPARATOR . 'manifest.json');

// vite membaca file dari folder pusat saat npm run dev
// $hotFilePath = $coreAppPath . '/public/hot';
// if (file_exists($hotFilePath)) {
//     // Memaksa Vite menggunakan file hot milik pusat
//     $app->singleton('vite.hotfile', fn() => $hotFilePath);
// }

// Jika menggunakan helper asset() untuk file statis di folder public pusat
// Kita buat alias agar asset() mengarah ke domain pusat atau menggunakan symlink.
// ---------------------------------------------------------

// Registrasi Folio
$app->booting(function () use ($coreAppPath) {
    $folioPath = $coreAppPath . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'pages';
    if (is_dir($folioPath)) {
        \Laravel\Folio\Folio::path($folioPath);
    }
});

// Jalankan Kernel
$kernel = $app->make(Kernel::class);
$response = $kernel->handle($request = Request::capture())->send();
$kernel->terminate($request, $response);
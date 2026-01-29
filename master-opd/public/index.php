<?php

use Dotenv\Dotenv;
use Illuminate\Http\Request;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\Facades\Vite;

// 1. Path Absolut ke Aplikasi Pusat
$coreAppPath = realpath(__DIR__ . '/../../web-builder-app');
require $coreAppPath . '/vendor/autoload.php';

// 2. Load .env dari folder anak
if (file_exists(dirname(__DIR__) . '/.env')) {
    $dotenv = Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();
}

// 3. Set Path Inti
putenv('CHILD_PROJECT_PATH=' . $coreAppPath);

// 4. Boot Aplikasi
$app = require_once dirname(__DIR__) . '/bootstrap/app.php';

// 5. Atur Path & Facade
$app->setBasePath($coreAppPath);
$app->usePublicPath(realpath(__DIR__));
Facade::setFacadeApplication($app);

// ---------------------------------------------------------
// 🔥 PERBAIKAN ASET (Vite & CSS/JS) 🔥
// ---------------------------------------------------------
// Memaksa Vite mencari manifest di folder pusat
$manifestPath = $coreAppPath . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'build';
Vite::useManifestFilename($manifestPath . DIRECTORY_SEPARATOR . 'manifest.json');

// Jika Anda menggunakan helper asset() untuk file statis di folder public pusat
// Kita buat alias agar asset() mengarah ke domain pusat atau menggunakan symlink.
// ---------------------------------------------------------

// 6. Registrasi Folio
$app->booting(function () use ($coreAppPath) {
    $folioPath = $coreAppPath . DIRECTORY_SEPARATOR . 'resources' . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR . 'pages';
    if (is_dir($folioPath)) {
        \Laravel\Folio\Folio::path($folioPath);
    }
});

// 7. Jalankan Kernel
$kernel = $app->make(Kernel::class);
$response = $kernel->handle($request = Request::capture())->send();
$kernel->terminate($request, $response);

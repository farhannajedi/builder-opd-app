<?php

/*
|--------------------------------------------------------------------------
| Jembatan Bootstrap Multi-Tenant
|--------------------------------------------------------------------------
| File ini memanggil bootstrap asli dari web-builder-app
*/

// Ambil path absolut ke aplikasi inti dari child project
$corePath = realpath(__DIR__ . '/../../web-builder-app');

// Kembalikan (return) aplikasi yang sudah di-boot oleh Core
return require_once $corePath . '/bootstrap/app.php';

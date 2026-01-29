<?php

/*
|--------------------------------------------------------------------------
| Jembatan Bootstrap Multi-Tenant
|--------------------------------------------------------------------------
| File ini memanggil bootstrap asli dari web-builder-app
*/

// Ambil path absolut ke aplikasi inti dari child project
$corePath = realpath(__DIR__ . '/../../web-builder-app');

// Validasi keberadaan core agar tidak blank page
// if (!$corePath || !file_exists($corePath . '/bootstrap/app.php')) {
//     header('HTTP/1.1 500 Internal Server Error');
//     echo "Fatal Error: Aplikasi Inti (Core) tidak ditemukan di: " . ($corePath ?: 'Path Invalid');
//     exit;
// }

// Kembalikan (return) aplikasi yang sudah di-boot oleh Core
return require_once $corePath . '/bootstrap/app.php';

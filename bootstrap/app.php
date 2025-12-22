<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$realBasePath = dirname(__DIR__);
if (getenv('CHILD_PROJECT_PATH')) {
    $realBasePath = getenv('CHILD_PROJECT_PATH');
}

return Application::configure(basePath: $realBasePath)
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',

        // HAPUS SEMUA BLOK 'then: function () { ... }'
        // Biarkan Folio didaftarkan dan dijalankan oleh $app->register() di index.php child.
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

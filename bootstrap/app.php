<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$realBasePath = dirname(__DIR__); // default (web-builder-app)
if (getenv('CHILD_PROJECT_PATH')) {
    $realBasePath = getenv('CHILD_PROJECT_PATH');
}

return Application::configure(basePath: $realBasePath)
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        // register folio
        then: function () {
            logger('Folio Loaded');
            $path = realpath(__DIR__ . '/../resources/views/pages');
            logger('Folio Path: ' . realpath(__DIR__ . '/../resources/views/pages'));
            \Laravel\Folio\Folio::path($path);
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

    // laravel cli
<?php

use Dotenv\Dotenv;

require __DIR__ . '/../../web-builder-app/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$childEnv = $dotenv->load();

$app = require_once __DIR__ . '/../../web-builder-app/bootstrap/app.php';

// gunakan public core
$app->usePublicPath(realpath(__DIR__ . '/../../web-builder-app/public'));

if (!empty($childEnv['APP_ID'])) {
    putenv("APP_ID={$childEnv['APP_ID']}");
    $_ENV['APP_ID'] = $childEnv['APP_ID'];
    $_SERVER['APP_ID'] = $childEnv['APP_ID'];
}

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();

$kernel->terminate($request, $response);

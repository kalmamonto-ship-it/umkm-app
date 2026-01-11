<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Check maintenance mode
if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register autoloader
require_once __DIR__.'/../vendor/autoload.php';

// Create application
$app = require_once __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Request::capture();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);

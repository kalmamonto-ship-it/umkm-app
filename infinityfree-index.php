<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Load InfinityFree specific configuration
if (file_exists(__DIR__.'/infinityfree-config.php')) {
    require_once __DIR__.'/infinityfree-config.php';
}

// Set environment for InfinityFree
if (!isset($_ENV['APP_ENV'])) {
    $_ENV['APP_ENV'] = 'production';
    $_ENV['APP_DEBUG'] = 'false';
    
    // Set default timezone
    date_default_timezone_set('Asia/Jakarta');
}

// Check maintenance mode
if (file_exists($maintenance = __DIR__.'/storage/framework/maintenance.php')) {
    require $maintenance;
}

// Register autoloader
require_once __DIR__.'/vendor/autoload.php';

// Create application
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Request::capture();
$response = $kernel->handle($request);
$response->send();
$kernel->terminate($request, $response);
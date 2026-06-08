<?php

define('LARAVEL_START', microtime(true));

// Setup /tmp storage SEBELUM apapun
$storagePath = '/tmp/storage';
$dirs = [
    $storagePath . '/framework/cache/data',
    $storagePath . '/framework/sessions',
    $storagePath . '/framework/views',
    $storagePath . '/logs',
    $storagePath . '/app/public',
];
foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Set env variable SEBELUM Laravel boot
$_ENV['APP_STORAGE_PATH'] = $storagePath;
putenv('APP_STORAGE_PATH=' . $storagePath);

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

// Override storage path setelah app dibuat tapi sebelum kernel
$app->useStoragePath($storagePath);

// Bind storage path ke config
$app->instance('path.storage', $storagePath);

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();
$kernel->terminate($request, $response);

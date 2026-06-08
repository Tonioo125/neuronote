<?php

define('LARAVEL_START', microtime(true));

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

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->useStoragePath($storagePath);
$app->instance('path.storage', $storagePath);

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

try {
    $request = Illuminate\Http\Request::capture();
    $response = $kernel->handle($request);
    $response->send();
    $kernel->terminate($request, $response);
} catch (\Throwable $e) {
    // Log error asli
    error_log('=== ROOT CAUSE ERROR ===');
    error_log('Message: ' . $e->getMessage());
    error_log('File: ' . $e->getFile() . ':' . $e->getLine());
    error_log('Trace: ' . $e->getTraceAsString());

    http_response_code(500);
    header('Content-Type: application/json');
    echo json_encode([
        'error' => $e->getMessage(),
        'file' => str_replace('/var/task/user/', '', $e->getFile()),
        'line' => $e->getLine(),
    ]);
}

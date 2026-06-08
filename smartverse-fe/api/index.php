<?php

define('LARAVEL_START', microtime(true));

require __DIR__ . '/../vendor/autoload.php';

// Setup /tmp storage dirs
$dirs = [
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/views',
    '/tmp/storage/logs',
    '/tmp/storage/app',
];

foreach ($dirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

try {
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    $app->useStoragePath('/tmp/storage');

    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

    $response = $kernel->handle(
        $request = Illuminate\Http\Request::capture()
    );

    $response->send();
    $kernel->terminate($request, $response);

} catch (\Throwable $e) {
    error_log('LARAVEL ERROR: ' . $e->getMessage() . ' in ' . $e->getFile() . ':' . $e->getLine());
    error_log('TRACE: ' . $e->getTraceAsString());
    http_response_code(500);
    echo json_encode([
        'error' => $e->getMessage(),
        'file' => $e->getFile(),
        'line' => $e->getLine(),
    ]);
}

<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$storagePath = '/tmp/storage';
foreach ([
    $storagePath . '/framework/cache/data',
    $storagePath . '/framework/sessions',
    $storagePath . '/framework/views',
    $storagePath . '/logs',
    $storagePath . '/app/public',
] as $dir) {
    if (!is_dir($dir)) mkdir($dir, 0755, true);
}

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Show raw error on Vercel instead of going through error handler
        $exceptions->render(function (\Throwable $e, $request) {
            return response()->json([
                'error' => $e->getMessage(),
                'file' => str_replace('/var/task/user/', '', $e->getFile()),
                'line' => $e->getLine(),
                'class' => get_class($e),
            ], 500);
        });
    })
    ->create()
    ->useStoragePath($storagePath);

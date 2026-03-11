<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up'
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api(prepend: [
            \App\Http\Middleware\CheckOwnerHeader::class,
            \App\Http\Middleware\LogApiRequests::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (\RedisException $e, $request) {
            Log::channel('health')->error("Redis unavailable");

            if ($request->is('api/*')) {
                return response()->json([
                    'db' => true,
                    'cache' => false,
                    'message' => 'Redis connection established',
                ], 500);
            }
        });
    })->create();

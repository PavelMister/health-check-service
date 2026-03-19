<?php

use App\Http\Middleware\CheckOwnerHeader;
use App\Http\Middleware\LogApiRequests;
use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up'
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->api(prepend: [
//            CheckOwnerHeader::class,
            LogApiRequests::class,
            SetLocale::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (RedisException $e, $request) {
            Log::channel('health')->error('Redis unavailable');

            if ($request->is('api/*')) {
                return response()->json([
                    'db' => true,
                    'cache' => false,
                    'message' => 'Redis unavailable',
                ], 500);
            }
        });
    })->create();

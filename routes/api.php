<?php

use Illuminate\Support\Facades\Route;

Route::middleware('throttle:v1_limits')->group(function () {
    // V1 version
    Route::prefix('v1')->group(function () {
        Route::get('health-check', [\App\Http\Controllers\V1\HealthController::class, 'checkHealth']);
    });
});

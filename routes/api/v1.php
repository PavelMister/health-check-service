<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\V1\HealthController;
use App\Http\Controllers\V1\UsersController;

Route::get('health-check', [HealthController::class, 'checkHealth']);

Route::prefix('users')->group(function () {
    Route::post('register', [UsersController::class, 'register']);
    Route::post('login', [UsersController::class, 'login']);
});

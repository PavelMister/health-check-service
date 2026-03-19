<?php

use Illuminate\Support\Facades\Route;

Route::middleware('throttle:v1_limits')
    ->prefix('v1')
    ->group(base_path('routes/api/v1.php'));

<?php

use Illuminate\Support\Facades\Route;

Route::prefix('api')->group(function () {

    Route::prefix('v1')->group(function () {
        Route::get('health-check', function () {
            echo 'test';
        });
    });


    Route::prefix('v2')->group(function () {
        Route::get('health-check', function () {
            echo 'test v2';
        });
    });
});

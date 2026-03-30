<?php

namespace App\Providers;

use DB;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Stop running lazy loading
        Model::preventLazyLoading(! app()->isProduction());

        // Save debug queries to log
        if (app()->isLocal()) {
            DB::listen(function ($query) {
                Log::info($query->sql, $query->bindings);
                Log::info($query->time);
            });
        }

        RateLimiter::for('v1_limits', function (Request $request) {
            return Limit::perMinute(60)->by($request->header('X-Owner') ?: $request->ip());
        });
    }
}

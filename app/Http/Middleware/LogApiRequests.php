<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class LogApiRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->attributes->set('request_uuid', Str::uuid()->toString());

        return $next($request);
    }

    public function terminate(Request $request, Response $response): void
    {
        DB::table('log_api_requests')->insert([
            'id' => (string) Str::uuid(),
            'owner_uuid' => $request->header('X-Owner', 'anonymous'),
            'method' => $request->method(),
            'path' => $request->path(),
            'payload' => json_encode($request->all()),
            'status_code' => $response->getStatusCode(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'duration_ms' => defined('LARAVEL_START') ? (microtime(true) - LARAVEL_START) * 1000 : 0,
            'created_at' => now(),
        ]);
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckOwnerHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ownerUuid = $request->header('X-Owner');

        if (!$ownerUuid || !Str::isUuid($ownerUuid)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid X-Owner request header'
            ]);
        }

        return $next($request);
    }
}

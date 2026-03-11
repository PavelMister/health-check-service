<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CheckOwnerHeader
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $ownerUuid = $request->header('X-Owner');

        if (! $ownerUuid || ! Str::isUuid($ownerUuid)) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid X-Owner request header',
            ], Response::HTTP_UNAUTHORIZED);
        }

        return $next($request);
    }
}

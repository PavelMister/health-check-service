<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * @param $data
     * @param string|null $message
     * @param int $code
     * @return JsonResponse
     */
    public function success($data, string $message = null, int $code = 200): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    public function error(string $message, array|null $errors = null, int $code = 400): JsonResponse
    {
        return response()->json([
            'status' => 'Errors',
            'message' => $message,
            'errors' => $errors
        ], $code);
    }

}

<?php

declare(strict_types=1);

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Redis\Factory as Redis;
use Illuminate\Database\DatabaseManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class HealthController extends Controller
{
    /**
     * Method for check health infrastructure
     */
    public function checkHealth(DatabaseManager $db, Redis $redis): JsonResponse
    {
        $status = [
            'db' => false,
            'cache' => false,
        ];

        try {
            $db->connection()->getPdo();
            $status['db'] = true;
        } catch (\Throwable $th) {
            Log::channel('health')->error('Database unavailable');
        }

        try {
            $status['cache'] = $redis->connection()->ping();
        } catch (\Throwable $th) {
            Log::channel('health')->error('Redis unavailable');
        }

        $allOk = ! in_array(false, $status, true);

        return response()->json($status, $allOk ? 200 : 500);
    }
}

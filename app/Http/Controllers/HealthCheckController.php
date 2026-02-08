<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class HealthCheckController extends Controller
{
    public function index(): JsonResponse
    {
        $checks = [
            'status' => 'ok',
            'timestamp' => now()->toIso8601String(),
            'checks' => []
        ];

        // Database check
        try {
            DB::connection()->getPdo();
            $checks['checks']['database'] = 'ok';
        } catch (\Exception $e) {
            $checks['status'] = 'error';
            $checks['checks']['database'] = 'failed';
        }

        // Cache check
        try {
            Cache::put('health_check', 'ok', 10);
            $value = Cache::get('health_check');
            $checks['checks']['cache'] = $value === 'ok' ? 'ok' : 'failed';
        } catch (\Exception $e) {
            $checks['checks']['cache'] = 'failed';
        }

        // Storage check
        $checks['checks']['storage'] = is_writable(storage_path()) ? 'ok' : 'failed';

        // Overall status
        foreach ($checks['checks'] as $check) {
            if ($check !== 'ok') {
                $checks['status'] = 'degraded';
                break;
            }
        }

        $statusCode = $checks['status'] === 'ok' ? 200 : 503;

        return response()->json($checks, $statusCode);
    }

    public function ping(): JsonResponse
    {
        return response()->json(['status' => 'ok', 'timestamp' => now()->toIso8601String()]);
    }
}

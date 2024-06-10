<?php

namespace App\Http\Controllers;

use PDOException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HealthCheckController extends Controller
{
    public function index()
    {
        try {
            DB::connection()->getPdo();
        } catch (PDOException $pdoException) {
            Log::error(
                'Database connection error',
                [
                    'message' => $pdoException->getMessage(),
                    'trace' => $pdoException->getTraceAsString(),
                ]
            );
            return response()
                ->json([
                    'status' => 'error',
                    'message' => 'Database connection error',
                ], 500);
        }

        return response()
            ->json([
                'status' => 'ok',
                'message' => 'Your application is working fine',
            ]);
    }
}

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HealthCheckController;
use App\Http\Controllers\Api\User\UserActivityLogController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return response()
        ->json([
            'message' => 'Welcome to my app'
        ]);
});

Route::get('/health-check', [HealthCheckController::class, 'index'])->name('health-check.index');

Route::post('/user-activity-logs', [UserActivityLogController::class, 'store'])->name('user-activity-logs.store');

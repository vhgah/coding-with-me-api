<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\PostController;
use App\Http\Controllers\Public\CategoryController;
use App\Http\Controllers\Public\HealthCheckController;

Route::get('/', function () {
    return response()
        ->json([
            'message' => 'Welcome to my app'
        ]);
});

Route::get('/health-check', [HealthCheckController::class, 'index'])->name('health-check.index');

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

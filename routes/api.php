<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AuthenticationController;

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/posts', [PostController::class, 'store']);
    Route::get('/me', [AuthenticationController::class, 'me']);
    Route::get('/logout', [AuthenticationController::class, 'logout']);
    Route::patch('/posts/{id}', [PostController::class, 'update'])->middleware('pemilik-postingan');
    Route::delete('/posts/{id}', [PostController::class, 'destroy'])->middleware('pemilik-postingan');
});

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/{id}', [PostController::class, 'show']);
Route::post('/login', [AuthenticationController::class, 'login']);
Route::post('/register', [AuthenticationController::class, 'register']);

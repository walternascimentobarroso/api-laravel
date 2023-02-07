<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TelegramController;

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource('tasks', TaskController::class);
    Route::get('telegram', [TelegramController::class, 'index']);
    Route::get('telegram/chats', [TelegramController::class, 'chats']);
});

Route::get('/me', [AuthController::class, 'me'])->name('auth.me')->middleware('auth:sanctum');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

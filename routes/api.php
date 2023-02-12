<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\OptionController;
use App\Http\Controllers\TelegramController;
use App\Http\Controllers\QuestionController;

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::apiResource('tasks', TaskController::class);
    Route::apiResource('options', OptionController::class);
    Route::apiResource('questions', QuestionController::class);
    Route::get('telegram/me', [TelegramController::class, 'me'])->name('telegram.me');
    Route::get('telegram/groups', [TelegramController::class, 'groups'])->name('telegram.groups');
    Route::get('telegram/sendMessage', [TelegramController::class, 'sendMessage'])->name('telegram.sendMessage');
});


Route::get('/me', [AuthController::class, 'me'])->name('auth.me')->middleware('auth:sanctum');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register'])->name('auth.register');

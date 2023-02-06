<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TelegramController;

Route::apiResource('tasks', TaskController::class);
Route::get('telegram', [TelegramController::class, 'index']);
Route::get('telegram/chats', [TelegramController::class, 'chats']);

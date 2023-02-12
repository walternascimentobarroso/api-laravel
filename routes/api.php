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

    Route::controller(TelegramController::class)->prefix('telegram')->group(function () {
        Route::get('me', 'me')->name('telegram.me');
        Route::get('groups', 'groups')->name('telegram.groups');
        Route::get('sendMessage', 'sendMessage')->name('telegram.sendMessage');
    });
});


Route::controller(AuthController::class)->group(function () {
    Route::get('me', 'me')->name('auth.me')->middleware('auth:sanctum');
    Route::post('login', 'login')->name('auth.login');
    Route::post('logout', 'logout')->name('auth.logout')->middleware('auth:sanctum');
    Route::post('register', 'register')->name('auth.register');
});

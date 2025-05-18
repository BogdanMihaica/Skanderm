<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\SkinConditionController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;


Route::controller(UserController::class)->group(function () {
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/users', [UserController::class, 'store']);
    Route::post('/logout', 'logout');

    // Route::middleware(['auth:sanctum'])->group(function () {    // Will add after 
        Route::get('/user', 'show');
        Route::get('/users/{user}', 'show');
        Route::put('/users/{user}', 'update');
        Route::delete('/users/{user}', 'destroy');
        
        // Route::middleware(IsAdmin::class)->group(function () {
            Route::get('/users', 'index');
        // });
    // });
});

Route::prefix('messages')->controller(MessageController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('{message}', 'show');
    Route::post('/', 'store');
});

Route::prefix('chats')->controller(ChatController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('{chat}', 'show'); 
    Route::post('/', 'store');
});

Route::prefix('plans')->controller(PlanController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('{plan}', 'show');
    Route::patch('{plan}', 'update');
});

Route::prefix('skin-conditions')->controller(SkinConditionController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('{skinCondition}', 'show');
    Route::post('/', 'store');
    Route::patch('{skinCondition}', 'update');
    Route::delete('{skinCondition}', 'destroy');
});

Route::prefix('orders')->controller(OrderController::class)->group(function () {
    Route::get('/', 'index');
    Route::get('{order}', 'show');
    Route::post('/', 'store');
    Route::patch('{order}', 'update');
    Route::delete('{order}', 'destroy');
});
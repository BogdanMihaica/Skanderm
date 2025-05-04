<?php

use App\Http\Controllers\UserController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;


Route::controller(UserController::class)->group(function () {
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/users', [UserController::class, 'store']);

    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/logout', 'logout');
        Route::get('/user', 'show');
        Route::get('/users/{user}', 'show');
        Route::put('/users/{user}', 'update');
        Route::delete('/users/{user}', 'destroy');
        
        Route::middleware(IsAdmin::class)->group(function () {
            Route::get('/users', 'index');
        });
    });
});

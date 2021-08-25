<?php

use App\Containers\Authentication\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')
    ->prefix('auth')
    ->name('auth.')
    ->group(function () {
        Route::post('/register', [Controllers\RegisterController::class, 'store'])->name('register');

        Route::post('/login', [Controllers\AuthController::class, 'login'])->name('login');
    });

Route::middleware('jwt.auth')
    ->prefix('auth')
    ->name('auth.')
    ->group(function () {
        Route::post('/logout', [Controllers\AuthController::class, 'logout'])->name('logout');
        Route::post('/refresh', [Controllers\AuthController::class, 'refresh'])->name('refresh');
    });

<?php

use App\Containers\Authentication\Http\Controllers;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])
    ->prefix('auth')
    ->name('auth.')
    ->group(function () {
        Route::post('/register', [Controllers\RegisterController::class, 'store'])->name('register');
    });

Route::middleware(['auth'])
    ->prefix('auth')
    ->name('auth.')
    ->group(function () {
        Route::get('/verify', [Controllers\VerificationController::class, 'verify'])->name('verify');
    });

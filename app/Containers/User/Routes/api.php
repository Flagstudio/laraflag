<?php

use App\Containers\User\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('jwt.auth')
    ->prefix('users')
    ->name('users.')
    ->group(function () {
        Route::get('show', [UserController::class, 'show'])->name('show');

        Route::post('update', [UserController::class, 'update'])->name('update');
    });

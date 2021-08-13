<?php

use App\Containers\User\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('show', [UserController::class, 'show'])->name('show');

        Route::post('update', [UserController::class, 'update'])->name('update');
    });

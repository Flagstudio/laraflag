<?php

use Illuminate\Support\Facades\Route;

Route::middleware('auth')
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::post('update', [\App\Containers\User\Http\Controllers\UserController::class, 'update'])->name('update');
    });

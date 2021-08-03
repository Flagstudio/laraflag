<?php

use App\Containers\Robots\Http\Controllers\RobotsController;

Route::get('robots.txt', [RobotsController::class, 'index'])->name('robots');

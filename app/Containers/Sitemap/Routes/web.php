<?php

use App\Containers\Sitemap\Http\Controllers\SitemapController;

Route::get('sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::view('/', 'main.index')->name('main');

Route::get('robots.txt', 'RobotsController@index')->name('robots.index');
Route::get('sitemap.xml', 'SitemapController@index')->name('sitemap.index');

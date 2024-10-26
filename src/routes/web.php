<?php

use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\ScraperController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.'
], function () {
    Route::get('/login', [IndexController::class, 'login'])->name('login');
    Route::get('/signin', [IndexController::class, 'signin'])->name('signin');
    Route::get('/reset-password', [IndexController::class, 'resetPassword'])->name('reset-password');
});

Route::group([
    'prefix' => 'admin/scraper',
    'as' => 'admin.scraper.'
], function () {
    Route::get('/', [ScraperController::class, 'index'])->name('index');
});

Route::get('/', function () {
    return view('welcome');
});

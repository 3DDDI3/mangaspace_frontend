<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\ScraperController;
use App\Http\Middleware\IsAuthenticated;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    'middleware' => IsAuthenticated::class
], function () {
    Route::get('/', [IndexController::class, 'index'])->name('index');
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/signin', [AuthController::class, 'signin'])->name('signin');
    Route::get('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');
});

Route::prefix('admin/scraper')
    ->middleware(IsAuthenticated::class)
    ->get('/', function () {
        return view('admin.layouts.pages.scraper');
    })->name('admin.scraper.index');

Route::get('/', function () {
    return view('welcome');
});

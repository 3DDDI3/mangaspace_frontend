<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ChapterController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\ScraperController;
use App\Http\Controllers\Admin\TitleController;
use App\Http\Middleware\IsAuthenticated;
use App\Services\ApiRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::prefix('admin')
    ->name('admin.')
    ->middleware(IsAuthenticated::class)
    ->group(function () {
        Route::get('/', [IndexController::class, 'index'])->name('index');
        Route::get('/login', [AuthController::class, 'login'])->name('login');
        Route::get('/signin', [AuthController::class, 'signin'])->name('signin');
        Route::get('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password');
    })->group(function () {
        Route::get('/titles', [TitleController::class, 'index'])->name('titles.index');
        Route::get('/titles/{slug}', [TitleController::class, 'show'])->name('titles.show');
        Route::get('/titles/{slug}/chapters/{chapter}', [ChapterController::class, 'index'])->name('titles.chapter.index');
    });

Route::prefix('admin/scraper')
    ->middleware(IsAuthenticated::class)
    ->name('admin.scraper.')
    ->group(function () {
        Route::get('/', [ScraperController::class, 'index'])->name('index');
    });

Route::get('test', function () {
    Storage::disk('shared')->delete('1.webp');
});

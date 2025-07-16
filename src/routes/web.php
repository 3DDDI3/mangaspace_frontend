<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ChapterController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\ScraperController;
use App\Http\Controllers\Admin\TitleController;
use App\Http\Controllers\Oauth\OauthController;
use App\Http\Middleware\IsAuthenticated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    ->name('admin.')
    ->middleware(IsAuthenticated::class)
    ->group(function () {
        Route::get('/', [IndexController::class, 'index'])->name('index');
        Route::get('/login', [AuthController::class, 'login'])->name('login');
        Route::get('/signin', [AuthController::class, 'signup'])->name('signup')->withoutMiddleware(IsAuthenticated::class);
        Route::get('/reset-password', [AuthController::class, 'resetPassword'])->name('reset-password')->withoutMiddleware(IsAuthenticated::class);
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

Route::prefix('auth')->group(function () {
    Route::get('redirect', [OauthController::class, 'redirect']);
    Route::get('callback', [OauthController::class, 'callback']);
});

Route::get('/redirect', function () {

    $query = http_build_query([
        'client_id' => '9f63fed4-7546-4cb0-9cec-30ed5a36b7c6',
        'redirect_uri' => 'http://mangaspace.ru:83/callback',
        'response_type' => 'code',
        'scope' => ''
    ]);

    return redirect('http://api.mangaspace.ru:83/oauth/authorize?' . $query);
});

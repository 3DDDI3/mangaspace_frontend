<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\IndexController;
use App\Http\Controllers\Admin\ScraperController;
use App\Http\Middleware\IsAuthenticated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
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

Route::get('/', function (Request $request) {
    preg_match("/laravel_session=([a-zA-Z0-9]+)/", $request->header('cookie'), $laravel_session);
    $laravel_session = $laravel_session[1];


    $response = Http::withOptions(['verify' => false])
        ->withHeaders([
            'Accept' => 'application/json',
            'Origin' => 'http://mangaspace.ru:82',
            // 'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0',
            'Cookie' => "laravel_session={$laravel_session}",
            'XSRF-TOKEN' => 'eyJpdiI6IlZ3YTRsbUFEK1ZQb1V0aE1jaFpxNUE9PSIsInZhbHVlIjoiL25nSE1DOUFMcktQemI5QU5MWXIyQ2ppcWZBbTE5ZVRRU1FjMUVCa3ZXdEY3YmxsMGhOOWJQaFhITDNTeWtqQkdhdDBxMWZEVXBjb0RIbXp5QTlKYVNJQWZteEVmQlpFbjdybWlDSkl5cDFMc3dnSDJQZlRYcUtiMWI5QXFHVkoiLCJtYWMiOiIwZmIyMjU5ZWI0OGI3MzAxNmRjNmFmZTlmNmNlMWJjYjJlMDU4ODc1MzgzY2I0NjYyOGMzZmY5NTc1ZDFjNWMxIiwidGFnIjoiIn0',
        ])
        ->get('http://host.docker.internal:83/v1.0/titles/');

    $colect = collect($request->json());

    return view('welcome')->with('persons', $colect);
});

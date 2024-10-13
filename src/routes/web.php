<?php

use App\Http\Controllers\Admin\IndexController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'admin',
    'ad' => 'admin.'
], function () {
    Route::get('/', [IndexController::class, 'login']);
});

Route::get('/', function () {
    return view('welcome');
});

<?php

use App\Events\TestEvent;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/test', function () {
    TestEvent::dispatch('test');
});

Route::get('/redis', function () {
    Redis::set('name', 'Taylor');
});

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;

class IndexController extends Controller
{
    public function __construct(Request $request) {}

    public function login(Request $request)
    {
        // $response = Http::withOptions(['verify' => false])
        //     ->get('http://host.docker.internal:83/auth/csrf-cookie');
        // $XSRF_TOKEN = $response->header('Set-Cookie');
        // $session = $response->header('laravel_session');

        // $response = Http::withOptions(['verify' => false])
        //     ->withHeaders([
        //         'X-XSRF-TOKEN' => $XSRF_TOKEN,
        //         'laravel_session' => $session,
        //         'Accept' => 'application/json',
        //         'Origin' => 'mangaspace.ru',
        //         'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0'
        //     ])
        //     ->post('http://host.docker.internal:83/v1.0/auth/login', [
        //         'name' => 'admin',
        //         'password' => 1234,
        //     ]);

        dd($request->header('cookie'));

        $response = Http::withOptions(['verify' => false])
            ->withHeaders([
                'X-XSRF-TOKEN' => $request->header('cookie'),
                'laravel_session' => $request->cookie('laravel_session'),
                'Accept' => 'application/json',
                'Origin' => 'mangaspace.ru',
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0'
            ]);

        dd($response);

        // return response()->view('admin.login')->cookie($XSRF_TOKEN);
    }
}

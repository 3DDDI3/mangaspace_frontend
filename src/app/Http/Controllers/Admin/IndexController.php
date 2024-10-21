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
        //     ->withHeaders([
        //         'Accept' => 'application/json',
        //         'Origin' => 'http://mangaspace.ru:82',
        //         'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0',
        //     ])
        //     ->get('http://host.docker.internal:83/auth/csrf-cookie');


        // $XSRF_TOKEN = null;
        // $laravel_session = null;
        // preg_match("/XSRF-TOKEN=([a-zA-Z0-9]+)/", $request->header('cookie'), $XSRF_TOKEN);
        // $XSRF_TOKEN = $XSRF_TOKEN[1];
        // preg_match("/laravel_session=([a-zA-Z0-9]+)/", $request->header('cookie'), $laravel_session);
        // $laravel_session = $laravel_session[1];

        // $response = Http::withOptions(['verify' => false])
        //     ->withHeaders([
        //         'Accept' => 'application/json',
        //         'Origin' => 'http://mangaspace.ru:82',
        //         // 'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0',
        //         'Cookie' => "laravel_session=eyJpdiI6IjNoN1NJRHgrU0hjZEV0bDRYckZTTVE9PSIsInZhbHVlIjoiUG54S0ZXaDkxbm8veXZ5K1BUZ0dReUtsT0Ryai90UWRscWhFN0NmSEZYa0RXYVZNdklWdE5INW9MRUZNWHdseFA2dHQ5VUxFY1RCSGhWeDl6T2FrTXJ1dXphRmJkOSs0V0M3SGFBb3Z3YTg2c3hWQUVFVDVyN09zTUxwQmwvelgiLCJtYWMiOiIzMjdiZDQwMjEwNWZlMmQ5MGUxOTYyNTI1ODYwYWI5MTU0NTI0ZGZmYzJhZjM1ZjM5MTVjNmZhY2E0YTlhMDljIiwidGFnIjoiIn0",
        //     ])
        //     ->get('http://host.docker.internal:83/v1.0/auth/check', [
        //         'name' => 'admin',
        //         'password' => 1234,
        //     ]);

        // echo "{$XSRF_TOKEN}\n{$laravel_session}";

        // dd($response);

        // return response()->view('admin.login')->withCookie(cookie('asd', '12312', 60, '/', '.mangaspace.ru', true));

        // dd($response->json());

        // preg_match("/laravel_session=([a-zA-Z0-9%;\s=,:\-\/.]+)samesite=[a-zA-Z0]+/", $response->header('Set-Cookie'), $laravel_session);
        // $laravel_session = $laravel_session[1];

        // $response = Http::withOptions(['verify' => false])
        //     // ->withCookies()
        //     ->withHeaders([
        //         'XSRF-TOKEN' => "{$XSRF_TOKEN}",
        //         // 'laravel_session' => 'eyJpdiI6IjBEY1BOTnJXd2xscFlyeHArbFp3dGc9PSIsInZhbHVlIjoiVmc1eU9qMU1qTCswZWFXblhUU3pTVnFwMUxFTzY5R2xuMWF4dTlpVnpTTHczT3RzS25xTGVqckhnNm5QZnAwS291MjRmdi9MSEgrZHFlL3YzZnBIVmx3OFhKS2RtYW14UXJFMEZtSTlualpTU3NxbUtBb2Vac0xPVGx3VkpheVkiLCJtYWMiOiI4MWFlYzU1MWY5OGRhYzI1NzZjY2U5ZGFlY2ZkNjM4MzU0OWM0ZThjZjMwNWFmZjhmMzRhNWI1YmVmNTk5YzNkIiwidGFnIjoiIn0',
        //         'Accept' => 'application/json',
        //         'Origin' => 'http://mangaspace.ru:82',
        //         'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0',
        //         'Cookie' => "laravel_session={$laravel_session}"
        //     ])
        //     ->get('http://host.docker.internal:83/v1.0/auth/check');

        // dd($response);

        // // $XSRF_TOKEN = Cookie::make("XSRF-TOKEN", $XSRF_TOKEN, 120, '/', '.mangaspace.ru');

        // // return view('admin.login');

        return response()->view('admin.auth.login');
    }

    public function signin()
    {
        return view('admin.auth.signin');
    }

    public function resetPassword()
    {
        return view('admin.auth.reset-password');
    }
}

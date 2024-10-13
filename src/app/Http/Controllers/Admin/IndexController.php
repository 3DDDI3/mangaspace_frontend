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
        $response = Http::withOptions(['verify' => false])
            ->get('http://host.docker.internal:83/auth/csrf-cookie');
        $XSRF_TOKEN = null;
        $laravel_session = null;
        preg_match("/XSRF-TOKEN=([a-zA-Z0-9]+)/", $response->header('Set-Cookie'), $XSRF_TOKEN);
        $XSRF_TOKEN = $XSRF_TOKEN[1];
        preg_match("/laravel_session=([a-zA-Z0-9]+)/", $response->header('Set-Cookie'), $laravel_session);
        $laravel_session = $laravel_session[1];

        $response = Http::withOptions(['verify' => false])
            ->withHeaders([
                'X-XSRF-TOKEN' => $XSRF_TOKEN,
                'laravel_session' => $laravel_session,
                'Accept' => 'application/json',
                'Origin' => 'mangaspace.ru',
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0'
            ])
            ->post('http://host.docker.internal:83/v1.0/auth/login', [
                'name' => 'admin',
                'password' => 1234,
            ]);

        dd($response);

        $cookies = [
            Cookie::make('XSRF-TOKEN', $XSRF_TOKEN, 120, '/', '.mangaspace.ru'),
            Cookie::make('laravel-session', $laravel_session, 120, '/', '.mangaspace.ru'),
        ];

        $response = Http::withOptions(['verify' => false])
            // ->withCookies()
            ->withHeaders([
                'X-XSRF-TOKEN' => 'eyJpdiI6ImVXaHpmRkdxbnhSd0VWRHArVVhuNmc9PSIsInZhbHVlIjoiM1VGMjIrT3NJUERvQ0xZcDBjVHhRU3dTL0xmNUdlRzFmbzdRb0hZQVRKQjNiV2V3RnRNSjZ0cXlUWDdEU1lBakVGYnBtWXpQd1Q3U2Y4Ymw4c25HSlQzbjFwTk5NeXk3OFk2SUVCUmNETkU1bHFHS0ZOenBHYjhzTk4xRUxTQ04iLCJtYWMiOiIzMTk1ZjUwZDFkMjEwM2FmZTk2Y2NmMmE1MWFkZTZlZjQ4MWU1YTQwMjljN2M3NzgxZjAxZTliMTZiYTE1NmZlIiwidGFnIjoiIn0',
                // 'laravel_session' => 'eyJpdiI6IjBEY1BOTnJXd2xscFlyeHArbFp3dGc9PSIsInZhbHVlIjoiVmc1eU9qMU1qTCswZWFXblhUU3pTVnFwMUxFTzY5R2xuMWF4dTlpVnpTTHczT3RzS25xTGVqckhnNm5QZnAwS291MjRmdi9MSEgrZHFlL3YzZnBIVmx3OFhKS2RtYW14UXJFMEZtSTlualpTU3NxbUtBb2Vac0xPVGx3VkpheVkiLCJtYWMiOiI4MWFlYzU1MWY5OGRhYzI1NzZjY2U5ZGFlY2ZkNjM4MzU0OWM0ZThjZjMwNWFmZjhmMzRhNWI1YmVmNTk5YzNkIiwidGFnIjoiIn0',
                'Accept' => 'application/json',
                'Origin' => 'http://mangaspace.ru:82',
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0'
            ])
            ->get('http://host.docker.internal:83/v1.0/auth/check');

        dd($response);

        // $XSRF_TOKEN = Cookie::make("XSRF-TOKEN", $XSRF_TOKEN, 120, '/', '.mangaspace.ru');

        // return view('admin.login');

        return view('admin.login');
    }
}

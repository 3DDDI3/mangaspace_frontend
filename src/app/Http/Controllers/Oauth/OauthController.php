<?php

namespace App\Http\Controllers\Oauth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use InvalidArgumentException;

class OauthController extends Controller
{
    public function redirect(Request $request)
    {
        $request->session()->put('state', $state = Str::random(40));

        $query = http_build_query([
            'client_id' => '9f600988-886f-4762-affb-f26107962144',
            'redirect_uri' => 'http://mangaspace.ru:82/auth/callback',
            'response_type' => 'code',
            'scope' => '',
            'state' => $state,
            // 'prompt' => '', // "none", "consent", or "login"
        ]);

        return redirect('https://api.mangaspace.ru:83/oauth/authorize?' . $query);
    }

    public function callback(Request $request)
    {
        $state = $request->session()->pull('state');

        throw_unless(
            strlen($state) > 0 && $state === $request->state,
            InvalidArgumentException::class,
            'Invalid state value.'
        );

        $response = Http::asForm()->post('https://api.mangaspace.ru/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => '9f600988-886f-4762-affb-f26107962144',
            'client_secret' => 'J2eTyhwuJX5rT6ft0jRkbLQ0twwxpjBQaTBuNtnx',
            'redirect_uri' => 'http://mangaspace.ru:82/auth/callback',
            'code' => $request->code,
        ]);

        return redirect()->intended('/test');
    }
}

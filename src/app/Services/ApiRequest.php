<?php

namespace App\Services;

use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

/**
 * Работа с api
 */
class ApiRequest
{
    public Response $response;

    /**
     * Отправка запроса к api
     *
     * @param Request $request
     * @param string $url
     * @param string $method
     * @return void
     */
    public function send(Request $request, string $url, string $method)
    {
        $this->response = Http::withHeaders([
            'Accept' => 'application/json',
            'Origin' => config('app.url'),
            'Cookie' => $request->header('cookie'),
        ])->send($method, config('app.api_url') . $url);
    }
}

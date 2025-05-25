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
     * @param string|null $accept
     * @param array|null $parameters
     * @return void
     */
    public function send(Request $request, string $url, string $method, ?string $accept = null, ?array $parameters = [])
    {
        $this->response = Http::withHeaders([
            'Accept' => $accept ?? "application/json",
            'Origin' => config('app.url'),
            'Cookie' => $request->header('cookie'),
        ])->send($method, config('app.api_url') . $url, ['query' => $parameters]);
    }
}

<?php

namespace App\Http\Middleware;

use App\Services\ApiRequest;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class IsAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiRequest = new ApiRequest();
        $apiRequest->send($request, '/v1.0/auth/check', 'get');

        if (!$apiRequest->response->ok() && $request->route()->getName() != 'admin.login')
            return redirect()->route('admin.login');
        else {
            if ($apiRequest->response->ok() && $request->route()->getName() != 'admin.scraper.index')
                return redirect()->route('admin.scraper.index');
            /** @todo Поменять путь при успешной авторизации в системе */
        }

        return $next($request);
    }
}

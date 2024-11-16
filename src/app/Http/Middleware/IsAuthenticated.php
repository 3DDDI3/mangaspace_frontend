<?php

namespace App\Http\Middleware;

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
        $response = Http::withOptions(['verify' => false])
            ->withHeaders([
                'Accept' => 'application/json',
                'Origin' => config('app.url'),
                'User-Agent' => $request->header('user-agent'),
                'Cookie' => $request->header('cookie'),
            ])
            ->get(config('app.api_url') . '/v1.0/auth/check');

        if (!$response->ok() && $request->route()->getName() != 'admin.login')
            return redirect()->route('admin.login');
        else {
            if ($response->ok() && $request->route()->getName() != 'admin.scraper.index')
                return redirect()->route('admin.scraper.index');
            /** @todo Поменять путь при успешной авторизации в системе */
        }

        return $next($request);
    }
}

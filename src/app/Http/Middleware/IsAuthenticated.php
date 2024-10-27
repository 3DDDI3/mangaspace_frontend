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
        if (empty($request->header('cookie'))) {
            if ($request->route()->getName() != 'admin.login')
                return redirect()->route('admin.login');
            else
                return $next($request);
        }

        preg_match("/laravel_session=([a-zA-Z0-9]+)/", $request->header('cookie'), $laravel_session);
        $laravel_session = $laravel_session[1];

        $response = Http::withOptions(['verify' => false])
            ->withHeaders([
                'Accept' => 'application/json',
                'Origin' => 'http://mangaspace.ru:82',
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/127.0.0.0 Safari/537.36 OPR/113.0.0.0',
                'Cookie' => "laravel_session={$laravel_session}",
            ])
            ->get('http://host.docker.internal:83/v1.0/auth/check');

        if (!$response->ok()) return redirect()->route('admin.login');

        if ($response->ok() && $request->route()->getName() == 'admin.login')
            return redirect()->route('admin.index');

        return $next($request);
    }
}

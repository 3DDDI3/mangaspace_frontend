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
        $cookies = collect(explode("; ", $request->header('cookie')));
        $cookieIndex = $cookies->search(function ($item) {
            if (preg_match("/token=/", $item))
                return $item;
        });

        $token = preg_replace("/token=/", "", $cookies->get($cookieIndex));
        // dd($token);

        $request->headers->set('Authorization', 'Bearer ' . $token);

        // $apiRequest = new ApiRequest();
        // $apiRequest->send($request, '/v1.0/auth/check', 'get', bearerToken: $token);

        // if (!$apiRequest->response->ok() && $request->route()->getName() != 'admin.login')
        //     return redirect()->route('admin.login');
        // else {
        //     if ($apiRequest->response->ok() && $request->route()->getName() == 'admin.login')
        //         return redirect()->route('admin.titles.index');
        // }

        return $next($request);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PersonType;
use App\Http\Controllers\Controller;
use App\Services\ApiRequest;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Http;

class TitleController extends Controller
{
    public function index(Request $request)
    {
        $api = new ApiRequest();
        $api->send(
            $request,
            "/v1.0/titles",
            "get",
            parameters: ['page' => !isset($request->page) ? 1 : $request->page]
        );
        $titles = $api->response->json();

        $api->send($request, "/v1.0/users", "get", parameters: ['active' => 1]);
        $user = $api->response->json();

        $api->send($request, "/v1.0/users/{$user['name']}/permissions", "get");
        $permissions = $api->response->json();

        $titlesData = $titles['data'];
        $perPage = $titles['meta']['per_page'];
        $currentPage = $titles['meta']['current_page'];
        $total = $titles['meta']['total'];

        $paginator = new LengthAwarePaginator(
            $titlesData,
            $total,
            $perPage,
            $currentPage,
            [
                'path' => Paginator::resolveCurrentPath(),
            ]
        );

        return view('admin.layouts.pages.titles', [
            'titles' => $paginator,
            'permissions' => $permissions,
        ]);
    }

    public function show(Request $request, $slug)
    {
        $api = new ApiRequest();
        $api->send(
            $request,
            "/v1.0/titles",
            "get",
            parameters: ['slug' => $slug]
        );
        $title = $api->response->json();

        $api->send(
            $request,
            "/v1.0/persons",
            "get",
        );

        $translators = collect($api->response->json());

        $api->send(
            $request,
            "/v1.0/titles/{$slug}/persons",
            "get",
            parameters: ['type' => PersonType::Translator->value]
        );

        $currentTranslators = collect($api->response->json());

        $api->send(
            $request,
            "/v1.0/title-translate-statuses",
            "get",
        );

        $translateStatuses = $api->response->json();

        $api->send(
            $request,
            "/v1.0/title-categories",
            "get"
        );

        $categories = $api->response->json();

        $api->send($request, "/v1.0/title-statuses", "get");
        $titleStatuses = $api->response->json();

        $api->send(
            $request,
            "/v1.0/titles/{$slug}/chapters",
            "get",
            parameters: ['offset' => 15],
        );

        $chapters = $api->response->json();

        $titlesData = $chapters['data'];
        $perPage = $chapters['meta']['per_page'];
        $currentPage = $chapters['meta']['current_page'];
        $total = $chapters['meta']['total'];

        $paginator = new LengthAwarePaginator(
            $titlesData,
            $total,
            $perPage,
            $currentPage,
            ['path' => Paginator::resolveCurrentPath()]
        );

        /**
         * Для ззапросов и основного сайта
         */
        // dd(Http::withHeaders([
        //     'Accept' => $accept ?? "application/json",
        //     'Origin' => config('app.url'),
        // ])
        //     ->withToken(config('app.api_token'))
        //     ->send("get", config('app.api_url') . "/v1.0/title-categories")->json());

        return view('admin.layouts.pages.title', [
            'title' => $title,
            'chapters' => $paginator,
            'translators' => $translators,
            'currentTranslators' => $currentTranslators,
            'titleStatuses' => $titleStatuses,
            'categories' => $categories,
            'translateStatuses' => $translateStatuses,
        ]);
    }
}

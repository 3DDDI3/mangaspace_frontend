<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Permission;
use App\Enums\PersonType;
use App\Http\Controllers\Controller;
use App\Services\ApiRequest;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

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
            "/v1.0/titles/{$slug}/chapters",
            "get",
            parameters: ['offset' => 15],
        );

        $chapters = $api->response->json();

        $api->send(
            $request,
            "/v1.0/persons",
            "get",
            parameters: ['type' => PersonType::Translator->value]
        );

        $translators = $api->response->json();

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

        return view('admin.layouts.pages.title', [
            'title' => $title,
            'chapters' => $paginator,
            'translators' => $translators,
        ]);
    }
}

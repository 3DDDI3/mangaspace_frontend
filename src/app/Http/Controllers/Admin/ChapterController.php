<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PersonType;
use App\Http\Controllers\Controller;
use App\Services\ApiRequest;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function index(Request $request, $slug, $chapter)
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
            "/v1.0/titles/{$slug}/chapters/{$chapter}",
            "get"
        );
        $chapter = $api->response->json();

        $api->send(
            $request,
            "/v1.0/persons",
            "get",
            parameters: ['type' => PersonType::Translator->value]
        );

        $translators = $api->response->json();

        return view('admin.layouts.pages.chapter', [
            'title' => $title,
            'chapter' => $chapter,
            'translators' => $translators,
        ]);
    }
}

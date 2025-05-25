<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ApiRequest;
use Illuminate\Http\Request;

class ScraperController extends Controller
{
    public function index(Request $request)
    {
        $api = new ApiRequest();
        $api->send(
            $request,
            "/v1.0/ws/info",
            "get",
            "text/html",
        );
        $block = $api->response;

        return view('admin.layouts.pages.scraper', [
            'block' => $block
        ]);
    }
}

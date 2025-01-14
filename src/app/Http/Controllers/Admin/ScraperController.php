<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\ApiRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ScraperController extends Controller
{
    public function index(Request $request)
    {
        $user = User::query()->find(1);
        $api = new ApiRequest();
        $api->send(
            $request,
            "/v1.0/ws/info",
            "get",
            "text/html",
            ['title' => 'vsevedushhii-citatel']
        );
        $block = $api->response;

        return view('admin.layouts.pages.scraper', [
            'user' => $user,
            'block' => $block
        ]);
    }
}

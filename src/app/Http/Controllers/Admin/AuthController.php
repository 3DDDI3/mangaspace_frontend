<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    public function __construct(Request $request) {}

    public function login(Request $request)
    {
        return response()->view('admin.layouts.auth.login');
    }

    public function signin()
    {
        return view('admin.layouts.auth.signin');
    }

    public function resetPassword()
    {
        return view('admin.layouts.auth.reset-password');
    }
}

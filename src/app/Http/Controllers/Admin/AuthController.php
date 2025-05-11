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
        return view('admin.layouts.auth.login');
    }

    public function signup()
    {
        return view('admin.layouts.auth.signup');
    }

    public function resetPassword()
    {
        return view('admin.layouts.auth.reset-password');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ScraperController extends Controller
{
    public function index()
    {
        return view('admin.layouts.pages.scraper');
    }
}

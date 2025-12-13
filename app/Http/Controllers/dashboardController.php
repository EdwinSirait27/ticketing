<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class dashboardController extends Controller
{
      public function dashboardPage()
    {
        return view('pages.dashboard');
    }
      public function aboutUs()
    {
        return view('pages.about');
    }
}
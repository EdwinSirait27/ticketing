<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class dashboardController extends Controller
{
      public function dashboardPage()
    {
       $user = Auth::user();
        return view('pages.dashboard', compact('user'));
    }
      public function aboutUs()
    {
        return view('pages.about');
    }
}
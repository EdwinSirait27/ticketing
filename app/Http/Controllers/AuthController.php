<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthController extends Controller
{
    public function loginPage()
    {
        return view('auth.login');
    }
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        if (Auth::attempt($credentials)) {
            return redirect('/dashboard');
        }
        return back()->withErrors(['msg' => 'Wrong Username or password']);
    }
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
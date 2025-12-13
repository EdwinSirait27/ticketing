<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
class AuthController extends Controller
{
    public function loginPage()
    {
        return view('auth.login');
    }
    // public function login(Request $request)
    // {
    //     $credentials = $request->only('username', 'password');
    //     if (Auth::attempt($credentials)) {
    //         return redirect('/dashboard');
    //     }
    //     return back()->withErrors(['msg' => 'Wrong Username or password']);
    // }
    public function login(Request $request)
{
    $credentials = $request->only('username', 'password');

    // Log credentials (hati-hati, jangan log password di production!)
    Log::info('Login attempt', [
        'username' => $credentials['username'] ?? null,
        'password_filled' => isset($credentials['password']) ? true : false,
    ]);

    if (Auth::attempt($credentials)) {
        Log::info('Login success', ['username' => $credentials['username']]);
        return redirect()->route('dashboard');
    }

    Log::warning('Login failed', ['username' => $credentials['username'] ?? null]);
    return back()->withErrors(['msg' => 'Wrong Username or password']);
}
    public function logout()
    {
        Auth::logout();
        // return redirect('/');
        return redirect()->route('login');

    }
}
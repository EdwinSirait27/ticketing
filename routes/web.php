<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('dashboard', function () {
//     return view('pages.dashboard');
// });

Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
Route::get('/lang/{lang}', function ($lang) {
    session(['applocale' => $lang]);
    return back();
})->name('lang.switch');
Route::get('/cek-session', function () {
    return session('applocale');
});



Route::get('/about', [dashboardController::class, 'aboutUs'])->name('about');
// Proses login (POST)
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout.post');
Route::get('/dashboard', [dashboardController::class, 'dashboardPage'])->name('dashboard')->middleware('auth');
Route::get('/profile', [ProfileController::class, 'profile'])->name('profile')->middleware('auth');
Route::get('/openticket', [TicketController::class, 'openTicket'])->name('openticket')->middleware('auth');
// Route::get('/', [AuthController::class, 'loginPage'])->name('loginPage');
// Route::post('/login', [AuthController::class, 'login'])->name('auth');

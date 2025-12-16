<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('dashboard', function () {
//     return view('pages.dashboard');
// });
Route::middleware('throttle:15,1')->group(function () {
Route::get('/', [AuthController::class, 'loginPage'])->name('login');
// Route::get('/login', [AuthController::class, 'loginPage'])->name('login');

Route::get('/lang/{lang}', function ($lang) {
    session(['applocale' => $lang]);
    return back();
})->name('lang.switch');
Route::get('/about', [dashboardController::class, 'aboutUs'])->name('about');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});



// Proses login (POST)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout.post');
Route::get('/dashboard', [dashboardController::class, 'dashboardPage'])->name('dashboard')->middleware('auth');
Route::get('/profile', [ProfileController::class, 'profile'])->name('profile')->middleware('auth');
Route::get('/openticket', [TicketController::class, 'openTicket'])->name('openticket')->middleware('auth');
Route::get('/users', [UserController::class, 'users'])->name('users')->middleware('auth');
Route::match(['GET', 'POST'], '/users/users', [UserController::class, 'getUsers'])->name('users.users')->middleware('auth');
        Route::get('/editusers/{hashedId}', [UserController::class, 'edit'])->name('editusers');


// Route::get('/', [AuthController::class, 'loginPage'])->name('loginPage');
// Route::post('/login', [AuthController::class, 'login'])->name('auth');

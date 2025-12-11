<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('dashboard', function () {
    return view('pages.dashboard');
});
Route::get('/', function () {
    return view('pages.login');
});
Route::get('/', [AuthController::class, 'loginPage'])->name('auth.login');
Route::post('/login', [AuthController::class, 'login'])->name('login');
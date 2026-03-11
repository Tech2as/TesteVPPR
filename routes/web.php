<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('auth/login');
});

Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/register', function () {
    return view('auth/register');
})->name('register');
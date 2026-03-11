<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Symfony\Component\Routing\Router;

Route::get('/', function () {
    return view('auth.login');
});

Route::post('/login', [AuthController::class, 'login'])->name('login');

// Rotas de registro
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register'])->name('register.post');

// Rotas do dashboard com proteção de autenticação
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
})->name('dashboard');
});
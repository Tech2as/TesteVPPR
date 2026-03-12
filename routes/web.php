<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ServiceController;

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
    Route::get('/dashboard', [ServiceController::class, 'index'])->name('dashboard'); 

    Route::post('/services', [ServiceController::class, 'store'])->name('services.store');
    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy'); 
    Route::put('/services/{service}', [ServiceController::class, 'update'])->name('services.update');
   
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
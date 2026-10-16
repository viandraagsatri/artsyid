<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');
Route::get('/register', [RegisterController::class, 'index'])->name('register');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/lupa.password', [AuthController::class, 'lupaPassword'])->name('lupa.password');

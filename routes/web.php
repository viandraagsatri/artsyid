<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DaftarArtist;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Katalog;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.post');
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.post');
    Route::get('/lupa.password', [AuthController::class, 'lupaPassword'])->name('lupa.password');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/register/artist', [DaftarArtist::class, 'index'])->name('register.artist');
    Route::post('/register/artist', [DaftarArtist::class, 'store'])->name('register.artist.post');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/katalog', [Katalog::class, 'index'])->name('katalog');
Route::get('/katalog/{id?}', [Katalog::class, 'detail'])->name('katalog.detail');

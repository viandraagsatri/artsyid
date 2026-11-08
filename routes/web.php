<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LupaPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DaftarArtist;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Katalog;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.post');
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.post');
    Route::get('/lupa-password', [LupaPasswordController::class, 'index'])->name('lupa-password');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/profile/katalog', [ProfileController::class, 'katalog'])->name('profile.katalog');
    Route::get('/profile/portofolio', [ProfileController::class, 'portofolio'])->name('profile.portofolio');
    Route::get('/profile/setting', [ProfileController::class, 'settings'])->name('profile.setting');
    Route::put('/profile/setting/updateProfile', [ProfileController::class, 'updateProfile'])->name('setting.updateProfile');
    Route::put('/profile/setting/updatePassword', [ProfileController::class, 'updatePassword'])->name('setting.updatePassword');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/register/artist', [DaftarArtist::class, 'index'])->name('register.artist');
    Route::post('/register/artist', [DaftarArtist::class, 'store'])->name('register.artist.post');
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/katalog', [Katalog::class, 'index'])->name('katalog');
Route::get('/katalog/{id?}', [Katalog::class, 'detail'])->name('katalog.detail');
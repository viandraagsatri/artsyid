<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LupaPasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DaftarArtist;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Katalog;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\Admin\ApplicationController as AdminApplicationController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\PayoutController as AdminPayoutController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

use App\Http\Controllers\Artist\CommissionMenuController as ArtistCommissionMenuController;
use App\Http\Controllers\Artist\OrderController as ArtistOrderController;
use App\Http\Controllers\Artist\PayoutController as ArtistPayoutController;
use App\Http\Controllers\Artist\PortfolioController as ArtistPortfolioController;
use App\Http\Controllers\Artist\TrackerController as ArtistTrackerController;

use App\Http\Controllers\User\CompletedArtworkController as UserCompletedArtworkController;
use App\Http\Controllers\User\InvoiceController as UserInvoiceController;
use App\Http\Controllers\User\OrderController as UserOrderController;

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.post');
    Route::get('/register', [RegisterController::class, 'index'])->name('register');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.post');
    Route::get('/lupa-password', [LupaPasswordController::class, 'index'])->name('lupa-password');
});

Route::group(['middleware' => ['auth', 'not_blocked']], function () {
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

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/{notification}/open', [NotificationController::class, 'open'])->name('notifications.open');

    Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
        Route::get('/payouts', [AdminPayoutController::class, 'index'])->name('payouts.index');
        Route::get('/payments', [AdminPaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/export', [AdminPaymentController::class, 'export'])->name('payments.export');
        Route::post('/payments/{payment}/approve', [AdminPaymentController::class, 'approve'])->name('payments.approve');
        Route::post('/payments/{payment}/reject', [AdminPaymentController::class, 'reject'])->name('payments.reject');
        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
        Route::get('/applications', [AdminApplicationController::class, 'index'])->name('applications.index');
        Route::post('/applications/{user}/verify', [AdminApplicationController::class, 'verify'])->name('applications.verify');
        Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
        Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
        Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
        Route::post('/users/{user}/block', [AdminUserController::class, 'block'])->name('users.block');
        Route::post('/users/{user}/unblock', [AdminUserController::class, 'unblock'])->name('users.unblock');
    });

    Route::group(['prefix' => 'artist', 'as' => 'artist.', 'middleware' => 'artist'], function () {
        Route::get('/orders', [ArtistOrderController::class, 'index'])->name('orders.index');
        Route::get('/tracker', [ArtistTrackerController::class, 'index'])->name('tracker.index');
        Route::get('/payouts', [ArtistPayoutController::class, 'index'])->name('payouts.index');
        Route::get('/menus', [ArtistCommissionMenuController::class, 'index'])->name('menus.index');
        Route::get('/menus/form_create_menu', [ArtistCommissionMenuController::class, 'create_menu'])->name('menus.form_create_menu');
        Route::post('/menus', [ArtistCommissionMenuController::class, 'store'])->name('menus.store');
        Route::get('/menus/{menu}/edit', [ArtistCommissionMenuController::class, 'edit'])->whereNumber('menu')->name('menus.edit');
        Route::put('/menus/{menu}', [ArtistCommissionMenuController::class, 'update'])->whereNumber('menu')->name('menus.update');
        Route::patch('/menus/{menu}/toggle', [ArtistCommissionMenuController::class, 'toggle'])->whereNumber('menu')->name('menus.toggle');
        Route::delete('/menus/{menu}', [ArtistCommissionMenuController::class, 'destroy'])->whereNumber('menu')->name('menus.destroy');
        Route::post('/menus/{menu}/addons', [ArtistCommissionMenuController::class, 'storeAddon'])->whereNumber('menu')->name('menus.addons.store');
        Route::put('/menus/{menu}/addons/{addon}', [ArtistCommissionMenuController::class, 'updateAddon'])->whereNumber(['menu', 'addon'])->name('menus.addons.update');
        Route::delete('/menus/{menu}/addons/{addon}', [ArtistCommissionMenuController::class, 'destroyAddon'])->whereNumber(['menu', 'addon'])->name('menus.addons.destroy');
        Route::delete('/menus/{menu}/samples/{sample}', [ArtistCommissionMenuController::class, 'destroySample'])->whereNumber(['menu', 'sample'])->name('menus.samples.destroy');
        Route::get('/portfolios', [ArtistPortfolioController::class, 'index'])->name('portfolios.index');
        Route::get('/portfolios/form_create_portofolio', [ArtistPortfolioController::class, 'create_portofolio'])->name('portfolios.form_create_portofolio');
    });

    Route::group(['prefix' => 'user', 'as' => 'user.', 'middleware' => 'user'], function () {
        Route::get('/orders', [UserOrderController::class, 'index'])->name('orders.index');
        Route::get('/invoices', [UserInvoiceController::class, 'index'])->name('invoices.index');
        Route::get('/completed', [UserCompletedArtworkController::class, 'index'])->name('completed.index');
    });
});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/katalog', [Katalog::class, 'index'])->name('katalog');
Route::get('/katalog/{id}', [Katalog::class, 'detail'])->whereNumber('id')->name('katalog.detail');
Route::get('/storage/commission-samples/{artistId}/{filename}', [ArtistCommissionMenuController::class, 'showSample'])
    ->whereNumber('artistId')
    ->where('filename', '[A-Za-z0-9_-]+\.(jpg|jpeg|png|webp|JPG|JPEG|PNG|WEBP)')
    ->name('commission-samples.show');

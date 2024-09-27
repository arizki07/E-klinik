<?php

use App\Http\Controllers\_00_Home\UsersController;
use App\Http\Controllers\_01_Master\Antrian;
use App\Http\Controllers\_01_Master\Pendaftaran;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Datatables\AntrianList;
use App\Http\Controllers\Datatables\PendaftaranList;
use App\Http\Controllers\Datatables\UsersList;
use Illuminate\Support\Facades\Route;


Route::resource('getUsers', UsersList::class);
Route::resource('getPendaftaran', PendaftaranList::class);
Route::resource('getAntrian', AntrianList::class);

Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'index')->name('login');
    Route::post('login', 'authenticate')->name('log.authenticate');
    Route::get('logout', 'logout');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('register', 'index')->name('register');
    Route::get('otps', 'otp')->name('otp.form');
    Route::post('register/action', 'actionRegist')->name('actionregister');
    Route::post('/otp/verify', 'verifyOtp')->name('otp.verify');
});

Route::controller(ForgotController::class)->group(function () {
    Route::get('forgot', 'index');
    Route::post('/forgot_password_post', 'submitForgotPasswordForm')->name('forgot.password.post');
    Route::get('/reset_password/{token}', 'showResetPasswordForm')->name('reset.password.form');
    Route::post('/reset_password_post', 'submitResetPasswordForm')->name('reset.password.post');
});

Route::middleware('auth')->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('dashboard', 'index');
        // Route untuk mengambil notifikasi
        Route::get('/notifications', 'getNotifications')->name('notifications');
    });

    Route::controller(UsersController::class)->group(function () {
        Route::get('users', 'users');
    });

    Route::controller(Pendaftaran::class)->group(function () {
        Route::get('daftar', 'pendaftaran');
    });


    Route::controller(Antrian::class)->group(function () {
        Route::get('antrian', 'antr')->name('view.atr');
        Route::post('/create/store', 'store');
    });
});

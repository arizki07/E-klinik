<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'index');
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
});

Route::middleware('auth')->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('dashboard', 'index');
    });
});

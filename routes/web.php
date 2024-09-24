<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Auth\ForgotController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'index');
});

Route::controller(RegisterController::class)->group(function () {
    Route::get('register', 'index')->name('register');
    Route::get('verify-email', 'verifyEmail')->name('verification.verify');
    Route::post('resgiter/post', 'register')->name('register.post');
});

Route::controller(ForgotController::class)->group(function () {
    Route::get('forgot', 'index');
});

Route::controller(DashboardController::class)->group(function () {
    Route::get('dashboard', 'index');
});

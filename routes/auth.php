<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
|
| These routes are for user authentication.
|
*/

// Login Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

// Register Routes
Route::middleware('guest')->group(function () {
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});

// Logout Route
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::middleware('guest')->group(function () {
    Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

// Email Verification Routes
Route::middleware('auth')->group(function () {
    Route::get('email/verify', [VerificationController::class, 'show'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');
});

// Social Authentication Routes
Route::prefix('auth')->group(function () {
    Route::get('google', [LoginController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('google/callback', [LoginController::class, 'handleGoogleCallback'])->name('auth.google.callback');
    Route::get('facebook', [LoginController::class, 'redirectToFacebook'])->name('auth.facebook');
    Route::get('facebook/callback', [LoginController::class, 'handleFacebookCallback'])->name('auth.facebook.callback');
});

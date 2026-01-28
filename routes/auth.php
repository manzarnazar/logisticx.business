<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Backend\MerchantManage\MerchantController;


Route::middleware(['isInstalled', 'XSS', 'guest'])->group(function () {

    Route::get('/signin',                           [AuthController::class, 'signin'])->name('signin');
    Route::post('/signin',                          [AuthController::class, 'signinPost'])->name('signin');

    Route::get('/signup',                           [AuthController::class, 'signup'])->name('signup');
    Route::post('signup',                           [MerchantController::class, 'signUpStore'])->name('signUpStore');
    Route::post('signup/resend-otp',                [MerchantController::class, 'resendOTP'])->name('signup.resendOTP');

    Route::get('signup/verify/email',               [AuthController::class, 'emailVerificationForm'])->name('signup.emailVerificationForm');
    Route::post('signup/verify/email',              [AuthController::class, 'emailVerification'])->name('signup.emailVerification');

    Route::get('/password/forgot',                  [AuthController::class, 'forgotPasswordForm'])->name('forgotPasswordForm');
    Route::post('/password/forgot',                 [AuthController::class, 'forgotPassword'])->name('forgotPassword');

    Route::get('password/forgot/verification',      [AuthController::class, 'otpVerificationForm'])->name('password.otpVerificationForm');
    Route::post('password/forgot/verification',     [AuthController::class, 'otpVerification'])->name('password.otpVerification');

    Route::get('/password/reset',                   [AuthController::class, 'passwordResetForm'])->name('password.resetForm');
    Route::post('/password/reset',                  [AuthController::class, 'passwordReset'])->name('passwordReset');

    //demo user login
    Route::get('demo/login',                        [AuthController::class, 'demoLogin'])->name('demo.login');
});

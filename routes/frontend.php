<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\Backend\ParcelController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Backend\CustomerInquiryController;

Route::middleware(['isInstalled', 'XSS'])->group(function () {

    // Home
    Route::get('/',                     [FrontendController::class, 'index'])->name('/');
    Route::get('/home',                 [FrontendController::class, 'index'])->name('home');

    if (config('app.app_demo')) :

        Route::get('landing-page', function () {
            return view('landing');
        });

    endif;
    Route::get('/home2',            [FrontendController::class, 'index'])->name('home2');


    // Pages
    Route::get('/about',                [FrontendController::class, 'about'])->name('frontend.about');
    Route::get('/privacy-return',       [FrontendController::class, 'privacyReturn'])->name('frontend.privacy_return');
    Route::get('/terms-condition',      [FrontendController::class, 'terms_Condition'])->name('frontend.terms_condition');

    Route::get('/parcel/track',         [FrontendController::class, 'track'])->name('parcel.track');

    // Charges
    Route::get('/charges',              [FrontendController::class, 'charges'])->name('frontend.charges');

    // Coverage
    Route::get('/coverage',             [FrontendController::class, 'coverage'])->name('frontend.coverage');

    // blog
    Route::get('/blogs',                [FrontendController::class, 'blogs'])->name('frontend.blogs');
    Route::get('/blog/{slug}',          [FrontendController::class, 'blogSingle'])->name('frontend.blog-single');

    // Contact
    Route::get('/contact-us',           [FrontendController::class, 'contactUs'])->name('frontend.contactUs');
    Route::post('/contact-us/store',    [ContactUsController::class, 'storeMessage'])->name('frontend.contactUs.store');

    Route::get('/service/{id}',       [FrontendController::class, 'serviceDetails'])->name('frontend.service_details');

    // Delivery Calculation 
    Route::post('/get-area',            [ParcelController::class, 'getArea'])->name('parcel.merchant.area');
    Route::post('/get-service-types',   [ParcelController::class, 'getServiceTypes'])->name('parcel.merchant.service-types');
    Route::post('/get-charge',          [ParcelController::class, 'getCharge'])->name('parcel.merchant.charge');
});

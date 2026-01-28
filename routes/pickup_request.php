<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\PickupRequest\PickupRequestController;

Route::group(['middleware' => 'auth'], function () {
    Route::group(['middleware' => 'XSS'], function () {
        Route::group(['prefix' => 'admin'], function () {
            //pickup request
            Route::prefix('pickup-request')->name('pickup.request.')->group(function () {
                Route::get('regular',                      [PickupRequestController::class, 'regular'])->name('regular')->middleware('hasPermission:pickup_request_regular');
                Route::get('express',                      [PickupRequestController::class, 'express'])->name('express')->middleware('hasPermission:pickup_request_express');
            });
        });
    });
});

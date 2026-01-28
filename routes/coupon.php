<?php

use App\Http\Controllers\Backend\CouponController;
use Illuminate\Support\Facades\Route;


Route::middleware(['isInstalled', 'XSS', 'auth'])->group(function () {

    Route::get('coupon/index',          [CouponController::class, 'index'])->name('coupon.index')->middleware('hasPermission:coupon_read');
    Route::get('coupon/index/create',         [CouponController::class, 'create'])->name('coupon.create')->middleware('hasPermission:coupon_create');
    Route::post('coupon/store',         [CouponController::class, 'store'])->name('coupon.store')->middleware('hasPermission:coupon_create');
    Route::get('coupon/index/edit/{id}',      [CouponController::class, 'edit'])->name('coupon.edit')->middleware('hasPermission:coupon_update');
    Route::put('coupon/update',         [CouponController::class, 'update'])->name('coupon.update')->middleware('hasPermission:coupon_update');
    Route::delete('coupon/delete/{id}', [CouponController::class, 'delete'])->name('coupon.delete')->middleware('hasPermission:coupon_delete');
    Route::post('coupon/apply',         [CouponController::class, 'apply'])->name('coupon.apply');
});

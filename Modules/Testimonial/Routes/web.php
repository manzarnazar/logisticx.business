<?php

use Illuminate\Support\Facades\Route;
use Modules\Testimonial\Http\Controllers\TestimonialController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['isInstalled', 'XSS', 'auth'])->group(function () {

    // admin panel routes
    Route::get('admin/website-setup/testimonial',                    [TestimonialController::class, 'index'])->name('testimonial.index')->middleware('hasPermission:testimonial_read');
    Route::get('admin/website-setup/testimonial/create',             [TestimonialController::class, 'create'])->name('testimonial.create')->middleware('hasPermission:testimonial_create');
    Route::post('admin/website-setup/testimonial/store',             [TestimonialController::class, 'store'])->name('testimonial.store')->middleware('hasPermission:testimonial_create');
    Route::get('admin/website-setup/testimonial/edit/{id}',          [TestimonialController::class, 'edit'])->name('testimonial.edit')->middleware('hasPermission:testimonial_update');
    Route::put('admin/website-setup/testimonial/update/{id}',        [TestimonialController::class, 'update'])->name('testimonial.update')->middleware('hasPermission:testimonial_update');
    Route::delete('admin/website-setup/testimonial/delete/{id}',     [TestimonialController::class, 'destroy'])->name('testimonial.delete')->middleware('hasPermission:testimonial_delete');
    Route::get('admin/website-setup/testimonial/status/update/{id}', [TestimonialController::class, 'statusUpdate'])->name('testimonial.status.update')->middleware('hasPermission:testimonial_update');
});

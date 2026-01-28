<?php

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

use Illuminate\Support\Facades\Route;
use Modules\Faq\Http\Controllers\FaqController;

Route::middleware(['isInstalled', 'XSS', 'auth'])->group(function () {

    Route::get('/admin/website-setup/faqs',                      [FaqController::class, 'index'])->middleware('hasPermission:faq_read')->name('faq.index');
    Route::get('/admin/website-setup/faqs/create',               [FaqController::class, 'create'])->middleware('hasPermission:faq_create')->name('faq.create');
    Route::post('/admin/website-setup/faqs/store',               [FaqController::class, 'store'])->middleware('hasPermission:faq_create')->name('faq.store');
    Route::get('/admin/website-setup/faqs/edit/{id}',            [FaqController::class, 'edit'])->middleware('hasPermission:faq_update')->name('faq.edit');
    Route::put('/admin/website-setup/faqs/update/{id}',          [FaqController::class, 'update'])->middleware('hasPermission:faq_update')->name('faq.update');
    Route::delete('/admin/website-setup/faqs/delete/{id}',       [FaqController::class, 'destroy'])->middleware('hasPermission:faq_delete')->name('faq.delete');
    Route::get('/admin/website-setup/faqs/status/update/{id}',   [FaqController::class, 'statusUpdate'])->middleware('hasPermission:faq_status_update')->name('faq.status.update');
});

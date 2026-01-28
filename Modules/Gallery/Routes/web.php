<?php

use Illuminate\Support\Facades\Route;
use Modules\Gallery\Http\Controllers\GalleryController;

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

Route::group([], function () {
    Route::resource('gallery', GalleryController::class)->names('gallery');

    Route::get('admin/website-setup/gallery',                     [GalleryController::class, 'index'])->name('gallery.index')->middleware('hasPermission:gallery_read');
    Route::get('admin/website-setup/gallery/create',              [GalleryController::class, 'create'])->name('gallery.create')->middleware('hasPermission:gallery_create');
    Route::post('admin/website-setup/gallery/store',              [GalleryController::class, 'store'])->name('gallery.store')->middleware('hasPermission:gallery_create');
    Route::get('admin/website-setup/gallery/edit/{id}',           [GalleryController::class, 'edit'])->name('gallery.edit')->middleware('hasPermission:gallery_update');
    Route::put('admin/website-setup/gallery/update/{id}',         [GalleryController::class, 'update'])->name('gallery.update')->middleware('hasPermission:gallery_update');
    Route::delete('admin/website-setup/gallery/delete/{id}',      [GalleryController::class, 'destroy'])->name('gallery.delete')->middleware('hasPermission:gallery_delete');
});

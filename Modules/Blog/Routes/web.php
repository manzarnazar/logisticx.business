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
use Modules\Blog\Http\Controllers\BlogController;


Route::middleware(['isInstalled', 'XSS', 'auth'])->group(function () {
    // admin panel routes
    Route::get('admin/website-setup/blogs',[BlogController::class, 'index'])->name('blog.index')->middleware('hasPermission:blog_read');
    Route::get('admin/website-setup/blogs/create',[BlogController::class, 'create'])->name('blog.create')->middleware('hasPermission:blog_create');
    Route::post('admin/website-setup/blogs/store',[BlogController::class, 'store'])->name('blog.store')->middleware('hasPermission:blog_create');
    Route::get('admin/website-setup/blogs/edit/{id}',[BlogController::class, 'edit'])->name('blog.edit')->middleware('hasPermission:blog_update');
    Route::put('admin/website-setup/blogs/update/{id}',[BlogController::class, 'update'])->name('blog.update')->middleware('hasPermission:blog_update');
    Route::delete('admin/website-setup/blogs/delete/{id}',[BlogController::class, 'destroy'])->name('blog.delete')->middleware('hasPermission:blog_delete');
    Route::get('admin/website-setup/blogs/status/update/{id}',[BlogController::class, 'statusUpdate'])->name('blog.status.update')->middleware('hasPermission:blog_status_update');
});

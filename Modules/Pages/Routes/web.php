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
use Modules\Pages\Http\Controllers\PagesController;

Route::middleware(['isInstalled', 'XSS', 'auth'])->group(function () {

	Route::get('admin/website-setup/page',                  [PagesController::class, 'index'])->name('page.index')->middleware('hasPermission:page_read');
	Route::get('admin/website-setup/page/edit/{id}',        [PagesController::class, 'edit'])->name('page.edit')->middleware('hasPermission:page_update');
	Route::put('admin/website-setup/page/update/{id}',      [PagesController::class, 'update'])->name('page.update')->middleware('hasPermission:page_update');
});

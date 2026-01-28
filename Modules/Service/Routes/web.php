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
use Modules\Service\Http\Controllers\ServiceController;

Route::middleware(['isInstalled', 'XSS', 'auth'])->prefix('admin/website-setup/service')->group(function () {

    Route::get('/',             [ServiceController::class, 'index'])->name('service.index')->middleware('hasPermission:service_read');
    Route::get('create',        [ServiceController::class, 'create'])->name('service.create')->middleware('hasPermission:service_create');
    Route::post('store',        [ServiceController::class, 'store'])->name('service.store')->middleware('hasPermission:service_create');
    Route::get('edit/{id}',          [ServiceController::class, 'edit'])->name('service.edit')->middleware('hasPermission:service_update');
    Route::put('/update',        [ServiceController::class, 'update'])->name('service.update')->middleware('hasPermission:service_update');
    Route::delete('delete/{id}',     [ServiceController::class, 'delete'])->name('service.delete')->middleware('hasPermission:service_delete');

    Route::get('update/status/{id}',     [ServiceController::class, 'statusUpdate'])->name('service.status.update')->middleware('hasPermission:service_status_update');
});

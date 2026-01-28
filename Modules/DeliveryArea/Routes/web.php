<?php

use Illuminate\Support\Facades\Route;
use Modules\DeliveryArea\Http\Controllers\DeliveryAreaController;


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
    Route::resource('deliveryarea', DeliveryAreaController::class)->names('deliveryarea');

    Route::get('admin/website-setup/delivery-area',                            [DeliveryAreaController::class, 'index'])->name('delivery_area.index')->middleware('hasPermission:delivery_area_read');
    Route::get('admin/website-setup/delivery-area/create',                     [DeliveryAreaController::class, 'create'])->name('delivery_area.create')->middleware('hasPermission:delivery_area_create');
    Route::post('admin/website-setup/delivery-area/store',                     [DeliveryAreaController::class, 'store'])->name('delivery_area.store')->middleware('hasPermission:delivery_area_create');
    Route::get('admin/website-setup/delivery-area/edit/{id}',                  [DeliveryAreaController::class, 'edit'])->name('delivery_area.edit')->middleware('hasPermission:delivery_area_update');
    Route::put('admin/website-setup/delivery-area/update/{id}',                [DeliveryAreaController::class, 'update'])->name('delivery_area.update')->middleware('hasPermission:delivery_area_update');
    Route::delete('admin/website-setup/delivery-area/delete/{id}',             [DeliveryAreaController::class, 'destroy'])->name('delivery_area.delete')->middleware('hasPermission:delivery_area_delete');
});

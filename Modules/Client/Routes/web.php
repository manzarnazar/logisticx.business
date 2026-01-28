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
use Modules\Client\Http\Controllers\ClientController;

Route::middleware(['isInstalled', 'XSS', 'auth'])->group(function () {
    // admin panel routes
    Route::get('admin/website-setup/client',                    [ClientController::class, 'index'])->name('client.index')->middleware('hasPermission:client_read');
    Route::get('admin/website-setup/client/create',             [ClientController::class, 'create'])->name('client.create')->middleware('hasPermission:client_create');
    Route::post('admin/website-setup/client/store',             [ClientController::class, 'store'])->name('client.store')->middleware('hasPermission:client_create');
    Route::get('admin/website-setup/client/edit/{id}',          [ClientController::class, 'edit'])->name('client.edit')->middleware('hasPermission:client_update');
    Route::put('admin/website-setup/client/update/{id}',        [ClientController::class, 'update'])->name('client.update')->middleware('hasPermission:client_update');
    Route::delete('admin/website-setup/client/delete/{id}',     [ClientController::class, 'destroy'])->name('client.delete')->middleware('hasPermission:client_delete');
    Route::get('admin/website-setup/client/status/update/{id}', [ClientController::class, 'statusUpdate'])->name('client.status.update')->middleware('hasPermission:client_status_update');
});

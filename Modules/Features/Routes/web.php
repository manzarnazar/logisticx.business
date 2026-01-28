<?php

use Illuminate\Support\Facades\Route;
use Modules\Features\Http\Controllers\FeaturesController;

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

    Route::get('admin/website-setup/features',                    [FeaturesController::class, 'index'])->name('features.index')->middleware('hasPermission:features_read');
    Route::get('admin/website-setup/features/create',             [FeaturesController::class, 'create'])->name('features.create')->middleware('hasPermission:features_create');
    Route::post('admin/website-setup/features/store',             [FeaturesController::class, 'store'])->name('features.store')->middleware('hasPermission:features_create');
    Route::get('admin/website-setup/features/edit/{id}',          [FeaturesController::class, 'edit'])->name('features.edit')->middleware('hasPermission:features_update');
    Route::put('admin/website-setup/features/update/{id}',        [FeaturesController::class, 'update'])->name('features.update')->middleware('hasPermission:features_update');
    Route::delete('admin/website-setup/features/delete/{id}',     [FeaturesController::class, 'destroy'])->name('features.delete')->middleware('hasPermission:features_delete');
    Route::get('admin/website-setup/features/status/update/{id}', [FeaturesController::class, 'statusUpdate'])->name('features.status.update')->middleware('hasPermission:features_status_update');
});




// Route::middleware(['isInstalled', 'XSS', 'auth'])->prefix('admin/website-setup/features')->name('features.')->group(function () {

//     Route::get('/',                     [FeaturesController::class, 'index'])->name('index')->middleware('hasPermission:features_read');
//     Route::get('/create',               [FeaturesController::class, 'create'])->name('create')->middleware('hasPermission:features_create');
//     Route::post('/store',               [FeaturesController::class, 'store'])->name('store')->middleware('hasPermission:features_create');
//     Route::get('/edit/{id}',            [FeaturesController::class, 'edit'])->name('edit')->middleware('hasPermission:features_update');
//     Route::put('/update/{id}',          [FeaturesController::class, 'update'])->name('update')->middleware('hasPermission:features_update');
//     Route::delete('/delete/{id}',       [FeaturesController::class, 'destroy'])->name('delete')->middleware('hasPermission:features_delete');
//     Route::get('/status/update/{id}',   [FeaturesController::class, 'statusUpdate'])->name('status.update')->middleware('hasPermission:features_status_update');
// });

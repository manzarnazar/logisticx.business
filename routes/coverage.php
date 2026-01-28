<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\CoverageController;

// This route file for coverage related route
// test route
// Route::get('test', fn () =>  'its working.');


Route::middleware(['isInstalled', 'XSS', 'auth'])->prefix('admin/coverage')->group(function () {

    Route::get('/',                     [CoverageController::class, 'index'])->name('coverage.index')->middleware('hasPermission:coverage_read');
    Route::get('create',                [CoverageController::class, 'create'])->name('coverage.create')->middleware('hasPermission:coverage_create');
    Route::post('store',                [CoverageController::class, 'store'])->name('coverage.store')->middleware('hasPermission:coverage_create');
    Route::get('edit/{id}',             [CoverageController::class, 'edit'])->name('coverage.edit')->middleware('hasPermission:coverage_update');
    Route::put('update',                [CoverageController::class, 'update'])->name('coverage.update')->middleware('hasPermission:coverage_update');
    Route::delete('delete/{id}',        [CoverageController::class, 'delete'])->name('coverage.delete')->middleware('hasPermission:coverage_delete');

    Route::post('coverage/detect-area', [CoverageController::class, 'detectArea'])->name('coverage.detectArea')->withoutMiddleware('auth');
});

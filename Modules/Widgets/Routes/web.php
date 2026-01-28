<?php

use Illuminate\Support\Facades\Route;
use Modules\Widgets\Http\Controllers\WidgetsController;

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

Route::middleware(['XSS'])->group(function () {
    // admin panel routes
    Route::group(['middleware' => 'auth'], function () {
        Route::prefix('admin/website-setup/widgets')->name('widgets.')->group(function () {
            Route::get('/',                             [WidgetsController::class,   'index'])->name('index')->middleware('hasPermission:widget_read');
            Route::get('/create',                       [WidgetsController::class,   'create'])->name('create')->middleware('hasPermission:widget_create');
            Route::post('/store',                       [WidgetsController::class,   'store'])->name('store')->middleware('hasPermission:widget_create');
            Route::get('/edit/{id}',                    [WidgetsController::class,   'edit'])->name('edit')->middleware('hasPermission:widget_update');
            Route::put('/update/{id}',                  [WidgetsController::class,   'update'])->name('update')->middleware('hasPermission:widget_update');
            Route::delete('/delete/{id}',               [WidgetsController::class,   'destroy'])->name('delete')->middleware('hasPermission:widget_delete');
            Route::get('/status/update/{id}',           [WidgetsController::class,   'statusUpdate'])->name('status.update')->middleware('hasPermission:widget_status_update');
        });
    });
});

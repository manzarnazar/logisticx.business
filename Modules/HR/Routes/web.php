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
use Modules\HR\Http\Controllers\HolidayController;
use Modules\HR\Http\Controllers\WeekendController;

// Route::prefix('hr')->group(function () {
//     Route::get('/', 'HRController@index');
// });

Route::middleware(['isInstalled', 'XSS', 'auth'])->group(function () {
    Route::get('hr/weekend',            [WeekendController::class, 'index'])->name('weekend.index')->middleware('hasPermission:weekend_read');
    Route::get('hr/weekend/edit/{id}',  [WeekendController::class, 'edit'])->name('weekend.edit')->middleware('hasPermission:weekend_update');
    Route::put('hr/weekend/update',     [WeekendController::class, 'update'])->name('weekend.update')->middleware('hasPermission:weekend_update');

    // holiday
    Route::get('hr/holiday',            [HolidayController::class, 'index'])->name('holiday.index')->middleware('hasPermission:holiday_read');
    Route::get('hr/holiday/create',     [HolidayController::class, 'create'])->name('holiday.create')->middleware('hasPermission:holiday_create');
    Route::post('hr/holiday/store',     [HolidayController::class, 'store'])->name('holiday.store')->middleware('hasPermission:holiday_create');
    Route::get('hr/holiday/edit/{id}',  [HolidayController::class, 'edit'])->name('holiday.edit')->middleware('hasPermission:holiday_update');
    Route::put('hr/holiday/update',     [HolidayController::class, 'update'])->name('holiday.update')->middleware('hasPermission:holiday_update');
    Route::delete('hr/holiday/delete/{id}', [HolidayController::class, 'delete'])->name('holiday.delete')->middleware('hasPermission:holiday_delete');
});

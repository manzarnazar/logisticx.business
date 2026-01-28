<?php

use Illuminate\Support\Facades\Route;
use Modules\Attendance\Http\Controllers\AttendanceController;

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
    Route::get('admin/attendance/',               [AttendanceController::class, 'index'])->name('attendance.index')->middleware('hasPermission:attendance_read');
    Route::get('admin/attendance/create',         [AttendanceController::class, 'create'])->name('attendance.create')->middleware('hasPermission:attendance_create');
    Route::post('admin/attendance/store',         [AttendanceController::class, 'store'])->name('attendance.store')->middleware('hasPermission:attendance_create');
    Route::get('admin/attendance/edit/{id}',      [AttendanceController::class, 'edit'])->name('attendance.edit')->middleware('hasPermission:attendance_update');
    Route::put('admin/attendance/update/',        [AttendanceController::class, 'update'])->name('attendance.update')->middleware('hasPermission:attendance_update');
    Route::delete('admin/attendance/delete/{id}', [AttendanceController::class, 'delete'])->name('attendance.delete')->middleware('hasPermission:attendance_delete');

    Route::post('admin/attendance/users/filter',  [AttendanceController::class, 'getUsers'])->name('attendance.users.getWithFilter')->middleware('hasPermission:attendance_create');
    Route::post('admin/attendance/user/search',   [AttendanceController::class, 'getUser'])->name('attendance.user.search')->middleware('hasPermission:attendance_create');
});

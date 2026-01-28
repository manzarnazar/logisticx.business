<?php

use Illuminate\Support\Facades\Route;
use Modules\Leave\Http\Controllers\LeaveTypeController;
use Modules\Leave\Http\Controllers\LeaveAssignController;
use Modules\Leave\Http\Controllers\LeaveRequestController;
use Modules\Leave\Http\Controllers\AllLeaveRequestController;

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

    Route::get('admin/leave/type',          [LeaveTypeController::class, 'index'])->name('leave.type.index')->middleware('hasPermission:leave_type_read');
    Route::get('admin/leave/type/create',         [LeaveTypeController::class, 'create'])->name('leave.type.create')->middleware('hasPermission:leave_type_create');
    Route::post('admin/leave/type//store',        [LeaveTypeController::class, 'store'])->name('leave.type.store')->middleware('hasPermission:leave_type_create');
    Route::get('admin/leave/type//edit/{id}',     [LeaveTypeController::class, 'edit'])->name('leave.type.edit')->middleware('hasPermission:leave_type_update');
    Route::put('admin/leave/type//update',        [LeaveTypeController::class, 'update'])->name('leave.type.update')->middleware('hasPermission:leave_type_update');
    Route::delete('admin/leave/type/delete/{id}', [LeaveTypeController::class, 'destroy'])->name('leave.type.delete')->middleware('hasPermission:leave_type_delete');


    Route::get('admin/leave/assign/index',            [LeaveAssignController::class, 'index'])->name('leave.assign.index')->middleware('hasPermission:leave_assign_read');
    Route::get('admin/leave/assign/index/create',           [LeaveAssignController::class, 'create'])->name('leave.assign.create')->middleware('hasPermission:leave_assign_create');
    Route::post('admin/leave/assign/store',           [LeaveAssignController::class, 'store'])->name('leave.assign.store')->middleware('hasPermission:leave_assign_create');
    Route::get('admin/leave/assign/index/edit/{id}',        [LeaveAssignController::class, 'edit'])->name('leave.assign.edit')->middleware('hasPermission:leave_assign_update');
    Route::put('admin/leave/assign/update',           [LeaveAssignController::class, 'update'])->name('leave.assign.update')->middleware('hasPermission:leave_assign_update');
    Route::delete('admin/leave/assign/delete/{id}',   [LeaveAssignController::class, 'destroy'])->name('leave.assign.delete')->middleware('hasPermission:leave_assign_delete');


    Route::get('/admin/leave/all-leave-request',                        [AllLeaveRequestController::class, 'index'])->name('all-leave-request.index');

    Route::get('/admin/leave/all-leave-request/update/status/{id}',     [AllLeaveRequestController::class, 'statusUpdate'])->name('leave-request-status-update')->middleware('hasPermission:leave_request_status_update');

    Route::post('/admin/leave/all-leave-request/modal',                 [AllLeaveRequestController::class, 'requestModal'])->name('request-modal');

    Route::post('/admin/leave/all-leave-request/pending',               [AllLeaveRequestController::class, 'requestPending'])->name('request-pending')->middleware('hasPermission:leave_request_status_update');

    Route::post('/admin/leave/all-leave-request/rejected',              [AllLeaveRequestController::class, 'requestRejected'])->name('request-rejected')->middleware('hasPermission:leave_request_status_update');

    Route::post('/admin/leave/all-leave-request/approved',              [AllLeaveRequestController::class, 'requestApproved'])->name('request-approved')->middleware('hasPermission:leave_request_status_update');

    Route::get('/admin/leave/all-leave-request/create',                 [AllLeaveRequestController::class, 'create'])->name('all-leave-request.create')->middleware('hasPermission:leave_request_create');

    Route::post('/admin/leave/all-leave-request/store',                 [AllLeaveRequestController::class, 'store'])->name('all-leave-request.store')->middleware('hasPermission:leave_request_create');

    Route::get('/admin/leave/all-leave-request/edit/{id}',              [AllLeaveRequestController::class, 'edit'])->name('all-leave-request.edit')->middleware('hasPermission:leave_request_update');

    Route::put('/admin/leave/all-leave-request/update/{id}',            [AllLeaveRequestController::class, 'update'])->name('all-leave-request.update')->middleware('hasPermission:leave_request_update');

    Route::delete('/admin/leave/all-leave-request/delete/{id}',         [AllLeaveRequestController::class, 'destroy'])->name('all-leave-request.delete')->middleware('hasPermission:leave_request_delete');

    // Route::get('/admin/leave/all-leave-request/create/departments',     [AllLeaveRequestController::class, 'getDepartments']);

    // Route::get('/admin/leave/all-leave-request/create/roles',           [AllLeaveRequestController::class, 'getRoles']);

    Route::get('admin/leave/all-leave-request/available-days/{id}/{typeId}', [AllLeaveRequestController::class, 'availableDaysCalc'])->name('leave.available-days');




    Route::get('admin/leave/my-leave-request/self',                            [LeaveRequestController::class, 'index'])->name('leave.request.self.index');
    Route::get('/admin/leave/my-leave-request/self/create',          [LeaveRequestController::class, 'create'])->name('leave-request.create')->middleware('hasPermission:leave_request_create');
    Route::post('/admin/leave/my-leave-request/store',          [LeaveRequestController::class, 'store'])->name('leave-request.store')->middleware('hasPermission:leave_request_create');
    Route::get('/admin/leave/my-leave-request/self/edit/{id}',       [LeaveRequestController::class, 'edit'])->name('leave-request.edit')->middleware('hasPermission:leave_request_update');
    Route::put('/admin/leave/my-leave-request/update/{id}',     [LeaveRequestController::class, 'update'])->name('leave-request.update')->middleware('hasPermission:leave_request_update');
    Route::delete('/admin/leave/my-leave-request/delete/{id}',  [LeaveRequestController::class, 'destroy'])->name('leave-request.delete')->middleware('hasPermission:leave_request_delete');

    Route::post('leave/request/get-types',                      [LeaveRequestController::class, 'getLeaveTypes'])->name('leave.request.types');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\UserRole\RoleController;
use App\Http\Controllers\Backend\UserRole\UserController;
use App\Http\Controllers\Backend\UserRole\DesignationController;
use App\Http\Controllers\Backend\UserRole\DepartmentController;

Route::middleware(['isInstalled', 'XSS', 'auth'])->group(function () {
    // role
    Route::get('admin/roles',                       [RoleController::class, 'index'])->name('roles')->middleware('hasPermission:role_read');
    Route::get('admin/roles/create',                [RoleController::class, 'create'])->name('roles.create')->middleware('hasPermission:role_create');
    Route::post('admin/roles/store',                [RoleController::class, 'store'])->name('roles.store')->middleware('hasPermission:role_create');
    Route::get('admin/roles/edit/{id}',             [RoleController::class, 'edit'])->name('roles.edit')->middleware('hasPermission:role_update');
    Route::put('admin/roles/update',                [RoleController::class, 'update'])->name('roles.update')->middleware('hasPermission:role_update');
    Route::delete('admin/role/delete/{id}',         [RoleController::class, 'delete'])->name('role.delete')->middleware('hasPermission:role_delete');

    // User
    Route::get('admin/users',                       [UserController::class, 'index'])->name('users')->middleware('hasPermission:user_read');
    Route::get('admin/users/filter',                [UserController::class, 'filter'])->name('users.filter')->middleware('hasPermission:user_read');
    Route::get('admin/users/create',                [UserController::class, 'create'])->name('users.create')->middleware('hasPermission:user_create');
    Route::post('admin/users/store',                [UserController::class, 'store'])->name('users.store')->middleware('hasPermission:user_create');
    Route::get('admin/users/edit/{id}',             [UserController::class, 'edit'])->name('users.edit')->middleware('hasPermission:user_update');
    Route::put('admin/users/update',                [UserController::class, 'update'])->name('users.update')->middleware('hasPermission:user_update');
    Route::get('admin/users/permissions/{id}',      [UserController::class, 'permission'])->name('users.permission')->middleware('hasPermission:permission_update');
    Route::put('admin/users/permissions/update',    [UserController::class, 'permissionsUpdate'])->name('users.permissions.update')->middleware('hasPermission:permission_update');
    Route::delete('admin/user/delete/{id}',         [UserController::class, 'delete'])->name('user.delete')->middleware('hasPermission:user_delete');

    Route::post('/user/search',                     [UserController::class, 'getUser'])->name('user.search');
    Route::post('/hub//users/',                     [UserController::class, 'getUsersByHub'])->name('user.getByHub');

    // Designation
    Route::get('admin/designations',                [DesignationController::class, 'index'])->name('designations')->middleware('hasPermission:designation_read');
    Route::get('admin/designations/create',         [DesignationController::class, 'create'])->name('designations.create')->middleware('hasPermission:designation_create');
    Route::post('admin/designations/store',         [DesignationController::class, 'store'])->name('designations.store')->middleware('hasPermission:designation_create');
    Route::get('admin/designations/edit/{id}',      [DesignationController::class, 'edit'])->name('designations.edit')->middleware('hasPermission:designation_update');
    Route::put('admin/designations/update',         [DesignationController::class, 'update'])->name('designations.update')->middleware('hasPermission:designation_update');
    Route::delete('admin/designation/delete/{id}',  [DesignationController::class, 'delete'])->name('designation.delete')->middleware('hasPermission:designation_delete');

    // Department
    Route::get('admin/departments',                 [DepartmentController::class, 'index'])->name('departments')->middleware('hasPermission:department_read');
    Route::get('admin/departments/create',          [DepartmentController::class, 'create'])->name('departments.create')->middleware('hasPermission:department_create');
    Route::post('admin/departments/store',          [DepartmentController::class, 'store'])->name('departments.store')->middleware('hasPermission:department_create');
    Route::get('admin/departments/edit/{id}',       [DepartmentController::class, 'edit'])->name('departments.edit')->middleware('hasPermission:department_update');
    Route::put('admin/departments/update',          [DepartmentController::class, 'update'])->name('departments.update')->middleware('hasPermission:department_update');
    Route::delete('admin/department/delete/{id}',   [DepartmentController::class, 'delete'])->name('department.delete')->middleware('hasPermission:department_delete');
});

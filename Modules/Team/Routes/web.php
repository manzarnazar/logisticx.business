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
use Modules\Team\Http\Controllers\TeamController;


Route::middleware(['isInstalled', 'XSS', 'auth'])->group(function () {

    // admin panel routes
    Route::get('admin/website-setup/teams',                    [TeamController::class, 'index'])->name('team.index')->middleware('hasPermission:team_read');
    Route::get('admin/website-setup/teams/create',             [TeamController::class, 'create'])->name('team.create')->middleware('hasPermission:team_create');
    Route::post('admin/website-setup/teams/store',             [TeamController::class, 'store'])->name('team.store')->middleware('hasPermission:team_create');
    Route::get('admin/website-setup/teams/edit/{id}',          [TeamController::class, 'edit'])->name('team.edit')->middleware('hasPermission:team_update');
    Route::put('admin/website-setup/teams/update/{id}',        [TeamController::class, 'update'])->name('team.update')->middleware('hasPermission:team_update');
    Route::delete('admin/website-setup/teams/delete/{id}',     [TeamController::class, 'destroy'])->name('team.delete')->middleware('hasPermission:team_delete');
    Route::get('admin/website-setup/teams/status/update/{id}', [TeamController::class, 'statusUpdate'])->name('team.status.update')->middleware('hasPermission:team_status_update');
});

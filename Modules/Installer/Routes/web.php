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
use Modules\Installer\Http\Controllers\InstallerController;

Route::group(['middleware'=>['isNotInstalled', 'XSS']],function () {
    Route::get('install',  [InstallerController::class,'index'])->name('install.index');
});


Route::group(['middleware'=>['XSS']],function () {
    Route::post('install',        [InstallerController::class,'do_install'])->name('install');
    Route::get('final',           [InstallerController::class,'finish'])->name('final');
});

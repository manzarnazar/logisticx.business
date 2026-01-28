<?php

use Illuminate\Support\Facades\Route;
use Modules\Language\Http\Controllers\LanguageController;
// use $MODULE_NAMESPACE$\Language\$CONTROLLER_NAMESPACE$\LanguageController;

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

    Route::get('admin/app-language',                        [LanguageController::class, 'index'])->name('language.index')->middleware('hasPermission:language_read');
    Route::get('admin/app-language/create',                 [LanguageController::class, 'create'])->name('language.create')->middleware('hasPermission:language_create');
    Route::post('admin/app-language/store',                 [LanguageController::class, 'store'])->name('language.store')->middleware('hasPermission:language_create');
    Route::get('admin/app-language/edit/{id}',              [LanguageController::class, 'edit'])->name('language.edit')->middleware('hasPermission:language_update');
    Route::put('admin/app-language/update',                 [LanguageController::class, 'update'])->name('language.update')->middleware('hasPermission:language_update');
    Route::get('admin/app-language/edit/phrase/{id}',       [LanguageController::class, 'editPhrase'])->name('language.edit.phrase')->middleware('hasPermission:language_phrase');
    Route::post('admin/app-language/update/phrase/{code}',  [LanguageController::class, 'updatePhrase'])->name('language.update.phrase')->middleware('hasPermission:language_phrase');
    Route::delete('admin/app-language/delete/{id}',         [LanguageController::class, 'delete'])->name('language.delete')->middleware('hasPermission:language_delete');

    Route::get('admin/app-language/change-module',          [LanguageController::class, 'changeModule'])->name('language.change.module');
});

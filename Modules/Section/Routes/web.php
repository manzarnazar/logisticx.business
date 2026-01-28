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
use Modules\Section\Http\Controllers\SectionController;

Route::middleware(['XSS'])->group(function () {
    Route::group(['prefix' => 'admin/website-setup', 'middleware' => 'auth'], function () {
        Route::prefix('section')->controller(SectionController::class)->name('section.')->group(function () {
            Route::get('/',                    'index')->name('index')->middleware('hasPermission:section_read');
            Route::get('/edit/{type}',         'edit')->name('edit')->middleware('hasPermission:section_update');
            Route::put('/update',              'update')->name('update')->middleware('hasPermission:section_update');
        });
        Route::get('/theme-appearance',         [SectionController::class, 'themeAppearance'])->name('section.theme_appearance')->middleware('hasPermission:section_read');
    });
});

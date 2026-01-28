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
use Modules\SocialLink\Http\Controllers\SocialLinkController;

Route::middleware(['XSS'])->group(function () {

    Route::group(['prefix' => 'admin/website-setup/social-link', 'middleware' => 'auth'], function () {

        Route::controller(SocialLinkController::class)->name('socialLink.')->group(function () {

            Route::get('/',                    'index')->name('index')->middleware('hasPermission:social_link_read');
            Route::get('/create',              'create')->name('create')->middleware('hasPermission:social_link_create');
            Route::post('/store',              'store')->name('store')->middleware('hasPermission:social_link_create');
            Route::get('/edit/{id}',           'edit')->name('edit')->middleware('hasPermission:social_link_update');
            Route::put('/update',              'update')->name('update')->middleware('hasPermission:social_link_update');
            Route::delete('/delete/{id}',      'destroy')->name('delete')->middleware('hasPermission:social_link_delete');
            Route::get('/status/update/{id}',  'statusUpdate')->name('status.update')->middleware('hasPermission:social_link_status_update');
        });
    });
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Charges\VASController;
use App\Http\Controllers\Backend\Charges\ChargesController;
use App\Http\Controllers\Backend\Setting\SettingsController;
use App\Http\Controllers\Backend\Charges\ServiceTypeController;
use App\Http\Controllers\Backend\Charges\ServiceFaqController;
use App\Http\Controllers\Backend\Charges\ProductCategoryController;
use App\Http\Controllers\Backend\Charges\HomePageSliderController;

Route::middleware(['isInstalled', 'XSS', 'auth'])->group(function () {

    // product category
    Route::get('admin/charges/product-category',                      [ProductCategoryController::class, 'index'])->name('productCategory')->middleware('hasPermission:product_category_read');
    Route::get('admin/charges/product-category/create',               [ProductCategoryController::class, 'create'])->name('productCategory.create')->middleware('hasPermission:product_category_create');
    Route::post('admin/charges/product-category/store',               [ProductCategoryController::class, 'store'])->name('productCategory.store')->middleware('hasPermission:product_category_create');
    Route::get('admin/charges/product-category/edit/{id}',            [ProductCategoryController::class, 'edit'])->name('productCategory.edit')->middleware('hasPermission:product_category_update');
    Route::put('admin/charges/product-category/update',               [ProductCategoryController::class, 'update'])->name('productCategory.update')->middleware('hasPermission:product_category_update');
    Route::delete('admin/charges/product-category/delete/{id?}',      [ProductCategoryController::class, 'delete'])->name('productCategory.delete')->middleware('hasPermission:product_category_delete');

    // service-type
    Route::get('admin/charges/service-type',                          [ServiceTypeController::class, 'index'])->name('serviceType')->middleware('hasPermission:service_type_read');
    Route::get('admin/charges/service-type/create',                   [ServiceTypeController::class, 'create'])->name('serviceType.create')->middleware('hasPermission:service_type_create');
    Route::post('admin/charges/service-type/store',                   [ServiceTypeController::class, 'store'])->name('serviceType.store')->middleware('hasPermission:service_type_create');
    Route::get('admin/charges/service-type/edit/{id}',                [ServiceTypeController::class, 'edit'])->name('serviceType.edit')->middleware('hasPermission:service_type_update');
    Route::put('admin/charges/service-type/update',                   [ServiceTypeController::class, 'update'])->name('serviceType.update')->middleware('hasPermission:service_type_update');
    Route::delete('admin/charges/service-type/delete/{id?}',          [ServiceTypeController::class, 'delete'])->name('serviceType.delete')->middleware('hasPermission:service_type_delete');


    // service-faq
    Route::get('admin/website/service-faq',[ServiceFaqController::class,'index'])->name('serviceFaq.index')->middleware('hasPermission:service_faq_read');

    Route::get('admin/website/service-faq/create',[ServiceFaqController::class, 'create'])->name('serviceFaq.create')->middleware('hasPermission:service_faq_create');
    Route::post('admin/website/service-faq/store',[ServiceFaqController::class, 'store'])->name('serviceFaq.store')->middleware('hasPermission:service_faq_create');
    Route::get('admin/website/service-faq/edit/{id}',[ServiceFaqController::class, 'edit'])->name('serviceFaq.edit')->middleware('hasPermission:service_faq_update');
    Route::put('admin/website/service-faq/update',[ServiceFaqController::class, 'update'])->name('serviceFaq.update')->middleware('hasPermission:service_faq_update');
    Route::delete('admin/website/service-faq/delete/{id?}',[ServiceFaqController::class, 'delete'])->name('serviceFaq.delete')->middleware('hasPermission:service_faq_delete');



    // home_page_slider
    Route::get('admin/website/home-page-slider',[HomePageSliderController::class,'index'])->name('HomePageSider.index')->middleware('hasPermission:home_page_slider_read');

    Route::get('admin/website/home-page-slider/create',[HomePageSliderController::class, 'create'])->name('HomePageSider.create')->middleware('hasPermission:home_page_slider_create');
    Route::post('admin/website/home-page-slider/store',[HomePageSliderController::class, 'store'])->name('HomePageSider.store')->middleware('hasPermission:home_page_slider_create');
    Route::get('admin/website/home-page-slider/edit/{id}',[HomePageSliderController::class, 'edit'])->name('HomePageSider.edit')->middleware('hasPermission:home_page_slider_update');
    Route::put('admin/website/home-page-slider/update',[HomePageSliderController::class, 'update'])->name('HomePageSider.update')->middleware('hasPermission:home_page_slider_update');
    Route::delete('admin/website/home-page-slider/delete/{id?}',[HomePageSliderController::class, 'delete'])->name('HomePageSider.delete')->middleware('hasPermission:home_page_slider_delete');

    // value-added-services
    Route::get('admin/charges/value-added-services',                  [VASController::class, 'index'])->name('vas')->middleware('hasPermission:vas_read');
    Route::get('admin/charges/value-added-services/create',           [VASController::class, 'create'])->name('vas.create')->middleware('hasPermission:vas_create');
    Route::post('admin/charges/value-added-services/store',           [VASController::class, 'store'])->name('vas.store')->middleware('hasPermission:vas_create');
    Route::get('admin/charges/value-added-services/edit/{id}',        [VASController::class, 'edit'])->name('vas.edit')->middleware('hasPermission:vas_update');
    Route::put('admin/charges/value-added-services/update',           [VASController::class, 'update'])->name('vas.update')->middleware('hasPermission:vas_update');
    Route::delete('admin/charges/value-added-services/delete/{id?}',  [VASController::class, 'delete'])->name('vas.delete')->middleware('hasPermission:vas_delete');

    // COD
    Route::get('admin/charges/charge/cod-and-others',                              [SettingsController::class, 'codAndOthers'])->name('cod-and-others')->middleware('hasPermission:cod_and_other_read');
    Route::put('charges/cod-and-others',                              [SettingsController::class, 'codAndOthersUpdate'])->name('cod-and-others.update')->middleware('hasPermission:cod_and_other_update');

    // Charges
    Route::get('admin/charges/index',                                [ChargesController::class, 'index'])->name('charge.index')->middleware('hasPermission:charges_read');
    Route::get('admin/charges/merchant/my-charge/{merchant_id?}',            [ChargesController::class, 'merchantCharge'])->name('merchant.my_charge');
    Route::get('admin/charges/index/create',                         [ChargesController::class, 'create'])->name('charges.create')->middleware('hasPermission:charges_create');
    Route::post('admin/charges/store',                         [ChargesController::class, 'store'])->name('charges.store')->middleware('hasPermission:charges_create');
    Route::get('admin/charges/index/edit/{id}',                      [ChargesController::class, 'edit'])->name('charges.edit')->middleware('hasPermission:charges_update');
    Route::put('admin/charges/update',                         [ChargesController::class, 'update'])->name('charges.update')->middleware('hasPermission:charges_update');
    Route::delete('admin/charges/delete/{id?}',                [ChargesController::class, 'delete'])->name('charges.delete')->middleware('hasPermission:charges_delete');
});

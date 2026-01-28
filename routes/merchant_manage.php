<?php

use App\Http\Controllers\Backend\MerchantManage\MerchantChargeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\MerchantManage\MerchantController;
use App\Http\Controllers\Backend\MerchantManage\MerchantManagePaymentController;

Route::middleware(['isInstalled', 'XSS', 'auth'])->group(function () { // Merchant Routes
    Route::get('admin/merchant/index',                [MerchantController::class, 'index'])->name('merchant.index')->middleware('hasPermission:merchant_read');
    Route::get('admin/merchant/index/create',               [MerchantController::class, 'create'])->name('merchant.create')->middleware('hasPermission:merchant_create');
    Route::post('admin/merchant/store',               [MerchantController::class, 'store'])->name('merchant.store')->middleware('hasPermission:merchant_create');
    Route::get('admin/merchant/index/edit/{id}',            [MerchantController::class, 'edit'])->name('merchant.edit')->middleware('hasPermission:merchant_update');
    Route::put('admin/merchant/update',               [MerchantController::class, 'update'])->name('merchant.update')->middleware('hasPermission:merchant_update');
    Route::delete('admin/merchant/delete/{id}',       [MerchantController::class, 'destroy'])->name('merchant.delete')->middleware('hasPermission:merchant_delete');
    Route::get('admin/merchant/index/view/{id}',            [MerchantController::class, 'view'])->name('merchant.view')->middleware('hasPermission:merchant_view');

    Route::post('admin/merchant/search',              [MerchantController::class, 'searchMerchant'])->name('merchant.search');

    //merchant manage payment
    Route::get('admin/payment/index',                 [MerchantManagePaymentController::class, 'index'])->name('merchant.manage.payment.index')->middleware('hasPermission:payment_read');
    Route::get('admin/payment/index/merchant/payment-request/index/payment/view/{id}',                   [MerchantManagePaymentController::class, 'view'])->name('merchantManage.payment.view');
    Route::get('admin/payment/index/create',                [MerchantManagePaymentController::class, 'create'])->name('merchant-manage.payment.create')->middleware('hasPermission:payment_create');
    Route::post('admin/merchant/account',             [MerchantManagePaymentController::class, 'merchantAccount'])->name('merchant-manage.merchant.account');
    Route::post('admin/merchant/unpaid-parcels',      [MerchantManagePaymentController::class, 'unpaidParcels'])->name('merchant.unpaidParcels');
    Route::post('admin/merchant/search-by-business-name', [MerchantManagePaymentController::class, 'merchantSearch'])->name('merchant-manage.merchant-search');
    Route::post('admin/payment/store',                [MerchantManagePaymentController::class, 'paymentStore'])->name('merchantmanage.payment.store')->middleware('hasPermission:payment_create');
    Route::get('admin/payment/edit/{id}',             [MerchantManagePaymentController::class, 'edit'])->name('merchatmanage.payment.edit')->middleware('hasPermission:payment_update');
    Route::put('admin/payment/update',                [MerchantManagePaymentController::class, 'update'])->name('merchantmanage.payment.update')->middleware('hasPermission:payment_update');
    Route::delete('admin/payment/delete/{id}',        [MerchantManagePaymentController::class, 'destroy'])->name('merchantmanage.payment.delete')->middleware('hasPermission:payment_delete');
    //merchant manage payment process
    Route::get('admin/payment/reject/{id}',           [MerchantManagePaymentController::class, 'reject'])->name('merchantmanage.payment.reject')->middleware('hasPermission:payment_reject');
    Route::get('admin/payment/cancel-reject/{id}',    [MerchantManagePaymentController::class, 'cancelReject'])->name('merchantmanage.payment.cancel-reject')->middleware('hasPermission:payment_reject');
    Route::get('admin/payment/process/{id}',          [MerchantManagePaymentController::class, 'process'])->name('merchantmanage.payment.process')->middleware('hasPermission:payment_process');
    Route::get('admin/payment/cancel-process/{id}',   [MerchantManagePaymentController::class, 'cancelProcess'])->name('merchantmanage.payment.cancel-process')->middleware('hasPermission:payment_process');
    Route::put('admin/payment/processed',             [MerchantManagePaymentController::class, 'processed'])->name('merchantmanage.payment.processed')->middleware('hasPermission:payment_process');
    Route::get('admin/payment/merchant/filter',       [MerchantManagePaymentController::class, 'merchantpaymentFilter'])->name('merchantmanage.payment.filter');

    //Merchant delivery charge routes
    Route::get('admin/merchant/{merchant}/delivery-charge/index',          [MerchantChargeController::class, 'index'])->name('merchant.deliveryCharge.index')->middleware('hasPermission:merchant_delivery_charge_read');
    Route::get('admin/merchant/{merchant}/delivery-charge/create',         [MerchantChargeController::class, 'create'])->name('merchant.deliveryCharge.create')->middleware('hasPermission:merchant_delivery_charge_create');
    Route::post('admin/merchant/{merchant}/delivery-charge/store',         [MerchantChargeController::class, 'store'])->name('merchant.deliveryCharge.store')->middleware('hasPermission:merchant_delivery_charge_create');
    Route::get('admin/merchant/{merchant}/delivery-charge/edit/{id}',      [MerchantChargeController::class, 'edit'])->name('merchant.deliveryCharge.edit')->middleware('hasPermission:merchant_delivery_charge_update');
    Route::put('admin/merchant/{merchant}/delivery-charge/update/',        [MerchantChargeController::class, 'update'])->name('merchant.deliveryCharge.update')->middleware('hasPermission:merchant_delivery_charge_update');
    Route::delete('admin/merchant/{merchant}/delivery-charge/delete/{id}', [MerchantChargeController::class, 'delete'])->name('merchant.deliveryCharge.delete')->middleware('hasPermission:merchant_delivery_charge_delete');

    Route::post('admin/merchant/{merchant}/delivery-charge/service-type',  [MerchantChargeController::class, 'serviceType'])->name('merchant.deliveryCharge.serviceType')->middleware('hasPermission:merchant_delivery_charge_create');
    Route::post('admin/merchant/{merchant}/delivery-charge/area',          [MerchantChargeController::class, 'area'])->name('merchant.deliveryCharge.area')->middleware('hasPermission:merchant_delivery_charge_create');
    Route::post('admin/merchant/{merchant}/delivery-charge/charge',        [MerchantChargeController::class, 'charge'])->name('merchant.deliveryCharge.charge')->middleware('hasPermission:merchant_delivery_charge_create');

    //Merchant delivery charge routes
    Route::get('admin/merchant/{merchant}/cod-charge/index',               [MerchantChargeController::class, 'codCharge'])->name('merchant.codCharge.index')->middleware('hasPermission:merchant_cod_charge_read');
    Route::put('admin/merchant/{merchant}/cod-charge/update/',             [MerchantChargeController::class, 'updateCodCharge'])->name('merchant.codCharge.update')->middleware('hasPermission:merchant_cod_charge_update');
});

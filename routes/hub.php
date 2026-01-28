<?php

use App\Http\Controllers\Backend\BranchManage\HubController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\BranchManage\HubPaymentController;
use App\Http\Controllers\Backend\HubPanel\HubPaymentRequestController;

Route::middleware(['isInstalled', 'XSS', 'auth'])->group(function () {

    // Hubs
    Route::get('hubs',                                      [HubController::class, 'index'])->name('hubs.index')->middleware('hasPermission:hub_read');
    Route::post('hubs/filter',                              [HubController::class, 'filter'])->name('hubs.filter')->middleware('hasPermission:hub_read');
    Route::get('hubs/create',                               [HubController::class, 'create'])->name('hubs.create')->middleware('hasPermission:hub_create');
    Route::post('hubs/store',                               [HubController::class, 'store'])->name('hubs.store')->middleware('hasPermission:hub_create');
    Route::get('hubs/edit/{id}',                            [HubController::class, 'edit'])->name('hubs.edit')->middleware('hasPermission:hub_update');
    Route::put('hubs/update',                               [HubController::class, 'update'])->name('hubs.update')->middleware('hasPermission:hub_update');
    Route::delete('hub/delete/{id}',                        [HubController::class, 'delete'])->name('hub.delete')->middleware('hasPermission:hub_delete');
    Route::get('hubs/view/{id}',                             [HubController::class, 'view'])->name('hub.view')->middleware('hasPermission:hub_view');

    //hub payment
    Route::get('hub/payment/request/index',                 [HubPaymentController::class, 'index'])->name('hub.hub-payment.index')->middleware('hasPermission:hub_payment_read');
    Route::get('hub/payment/request/index/create',                [HubPaymentController::class, 'create'])->name('hub.hub-payment.create')->middleware('hasPermission:hub_payment_create');
    Route::post('hub/payment/request/store',                [HubPaymentController::class, 'paymentStore'])->name('hub.hub-payment.store')->middleware('hasPermission:hub_payment_create');
    Route::get('hub/payment/request/index/edit/{id}',             [HubPaymentController::class, 'edit'])->name('hub.hub-payment.edit')->middleware('hasPermission:hub_payment_update');
    Route::put('hub/payment/request/update/',               [HubPaymentController::class, 'update'])->name('hub.hub-payment.update')->middleware('hasPermission:hub_payment_update');
    Route::delete('hub/payment/request/delete/{id}',        [HubPaymentController::class, 'delete'])->name('hub.hub-payment.delete')->middleware('hasPermission:hub_payment_delete');

    //hub payment process
    Route::get('hub/payment/reject/{id}',                   [HubPaymentController::class, 'reject'])->name('hub-payment.reject')->middleware('hasPermission:hub_payment_reject');
    Route::get('hub/payment/cancel-reject/{id}',            [HubPaymentController::class, 'cancelReject'])->name('hub-payment.cancel-reject')->middleware('hasPermission:hub_payment_reject');
    Route::get('hub/payment/process/{id}',                  [HubPaymentController::class, 'process'])->name('hub-payment.process')->middleware('hasPermission:hub_payment_process');
    Route::get('hub/payment/cancel-process/{id}',           [HubPaymentController::class, 'cancelProcess'])->name('hub-payment.cancel-process')->middleware('hasPermission:hub_payment_process');
    Route::put('hub/payment/processed',                     [HubPaymentController::class, 'processed'])->name('hub-payment.processed')->middleware('hasPermission:hub_payment_process');

    //hub panel payment-request
    Route::get('hub-panel/payment-request/index',           [HubPaymentRequestController::class, 'index'])->name('hub-panel.payment-request.index')->middleware('hasPermission:hub_payment_request_read');
    Route::get('hub-panel/payment-request/create',          [HubPaymentRequestController::class, 'create'])->name('hub-panel.payment-request.create')->middleware('hasPermission:hub_payment_request_create');
    Route::post('hub-panel/payment-request/store',          [HubPaymentRequestController::class, 'store'])->name('hub-panel.payment-request.store')->middleware('hasPermission:hub_payment_request_create');
    Route::get('hub-panel/payment-request/edit/{id}',       [HubPaymentRequestController::class, 'edit'])->name('hub-panel.payment-request.edit')->middleware('hasPermission:hub_payment_request_update');
    Route::put('hub-panel/payment-request/update',          [HubPaymentRequestController::class, 'update'])->name('hub-panel.payment-request.update')->middleware('hasPermission:hub_payment_request_update');
    Route::delete('hub-panel/payment-request/delete/{id}',  [HubPaymentRequestController::class, 'delete'])->name('hub-panel.payment-request.delete')->middleware('hasPermission:hub_payment_request_delete');
});

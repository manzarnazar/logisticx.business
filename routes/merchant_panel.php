<?php

use App\Http\Controllers\Backend\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\MerchantPanel\PaymentAccountController;
use App\Http\Controllers\Backend\MerchantPanel\AccountTransactionController;
use App\Http\Controllers\Backend\MerchantPanel\PaymentRequestController;
use App\Http\Controllers\Backend\MerchantPanel\ShopsController;
use App\Http\Controllers\Backend\MerchantPanel\SupportController as MerchantPanelSupportController;
use App\Http\Controllers\Backend\MerchantPanel\FraudController as MerchantPanelFraudController;
use App\Http\Controllers\Backend\MerchantPanel\MerchantReportsController;
use App\Http\Controllers\Backend\MerchantPanel\MerchantParcelController;
use App\Http\Controllers\Backend\MerchantPanel\PickupRequestController;
use App\Http\Controllers\Backend\MerchantPanel\ReportsController;

// Merchant panel Routes
Route::middleware(['isInstalled', 'XSS', 'auth'])->group(function () {

    Route::post('merchant/dashboard/filter',                        [DashboardController::class, 'merchantDashboardFilter'])->name('merchant-panel.dashboard.filter');

    //accounts
    Route::get('payment/accounts',                                  [PaymentAccountController::class, 'index'])->name('merchant.payment.account.index');
    Route::get('payment/accounts/create',                           [PaymentAccountController::class, 'create'])->name('merchant.payment.account.create');
    Route::get('payment/accounts/edit/{id}',                         [PaymentAccountController::class, 'edit'])->name('merchant.payment.account.edit');

    // Account Transaction
    Route::get('merchant/accounts/account-transaction',             [AccountTransactionController::class, 'index'])->name('merchant.accounts.account-transaction.index');
    Route::post('merchant/accounts/account-transaction-filter',     [AccountTransactionController::class, 'filter'])->name('merchant.accounts.account-transaction.filter');

    // Shops routes
    Route::get('merchant/shops/index',                              [ShopsController::class, 'index'])->name('merchant-panel.shops.index');
    Route::get('merchant/shops/create',                             [ShopsController::class, 'create'])->name('merchant-panel.shops.create');
    Route::post('merchant/shops/store',                             [ShopsController::class, 'store'])->name('merchant-panel.shops.store');
    Route::get('merchant/shops/edit/{id}',                          [ShopsController::class, 'edit'])->name('merchant-panel.shops.edit');
    Route::put('merchant/shops/update/{id}',                        [ShopsController::class, 'update'])->name('merchant-panel.shops.update');
    Route::delete('merchant/shops/delete/{id}',                     [ShopsController::class, 'delete'])->name('merchant-panel.shops.delete');
    Route::post('merchant/shop/details',                            [ShopsController::class, 'shopDetails'])->name('merchantPanel.shopDetails');
    Route::get('merchant/shop/{id}/make-default',                   [ShopsController::class, 'defaultShop'])->name('shop.makeDefault');

    // Parcel Routes
    Route::get('merchant/parcel/filter',                            [MerchantParcelController::class, 'filter'])->name('merchant-panel.parcel.filter');
    Route::get('merchant/parcel-bank/index',                        [MerchantParcelController::class, 'parcelBank'])->name('merchant-panel.parcel-bank.index');
    Route::get('merchant/parcel/details/{id}',                      [MerchantParcelController::class, 'details'])->name('merchant-panel.parcel.details');

    //import
    Route::get('merchant/parcel/file-export',                       [MerchantParcelController::class, 'parcelExport'])->name('merchant-panel.parcel.file-export');
    Route::get('merchant/reports/parcel-reports',                   [MerchantReportsController::class, 'parcelReports'])->name('merchant-panel.parcel.reports');
    Route::get('merchant/reports/parcel-filter-reports',            [MerchantReportsController::class, 'parcelSReports'])->name('merchant-panel.parcel.filter.reports');
    Route::get('merchant/parcel-reports-print-page/{array}',        [MerchantReportsController::class, 'parcelReportsPrint'])->name('merchant-panel.parcel.reports.print.page');

    //payment request
    Route::get('merchant/payment-request/index',                 [PaymentRequestController::class, 'index'])->name('merchant-panel.payment-request.index');
    Route::get('merchant/payment-request/create',                [PaymentRequestController::class, 'create'])->name('merchant-panel.payment-request.create');
    Route::post('merchant/payment-request/store',                [PaymentRequestController::class, 'store'])->name('merchant-panel.payment-request.store');
    Route::get('merchant/payment-request/edit/{id}',             [PaymentRequestController::class, 'edit'])->name('merchant-panel.payment-request.edit');
    Route::put('merchant/payment-request/update',                [PaymentRequestController::class, 'update'])->name('merchant-panel.payment-request.update');
    Route::delete('merchant/payment-request/delete/{id}',        [PaymentRequestController::class, 'delete'])->name('merchant-panel.payment-request.delete');

    // Support
    Route::get('merchant/support/index',                         [MerchantPanelSupportController::class, 'index'])->name('merchant-panel.support.index');
    Route::get('merchant/support/create',                        [MerchantPanelSupportController::class, 'create'])->name('merchant-panel.support.add');
    Route::post('merchant/support/store',                        [MerchantPanelSupportController::class, 'store'])->name('merchant-panel.support.store');
    Route::get('merchant/support/edit/{id}',                     [MerchantPanelSupportController::class, 'edit'])->name('merchant-panel.support.edit');
    Route::put('merchant/support/update/{id}',                   [MerchantPanelSupportController::class, 'update'])->name('merchant-panel.support.update');
    Route::delete('merchant/support/delete/{id}',                [MerchantPanelSupportController::class, 'destroy'])->name('merchant-panel.support.delete');
    Route::get('merchant/support/view/{id}',                     [MerchantPanelSupportController::class, 'view'])->name('merchant-panel.support.view');
    Route::post('merchant/support/reply',                        [MerchantPanelSupportController::class, 'supportReply'])->name('merchant-panel.support.reply');

    // Fraud
    Route::get('merchant/fraud',                                 [MerchantPanelFraudController::class, 'index'])->name('merchant-panel.fraud.index');
    Route::get('merchant/fraud/create',                          [MerchantPanelFraudController::class, 'create'])->name('merchant-panel.fraud.create');
    Route::post('merchant/fraud/store',                          [MerchantPanelFraudController::class, 'store'])->name('merchant-panel.fraud.store');
    Route::get('merchant/fraud/edit/{id}',                       [MerchantPanelFraudController::class, 'edit'])->name('merchant-panel.fraud.edit');
    Route::put('merchant/fraud/update',                          [MerchantPanelFraudController::class, 'update'])->name('merchant-panel.fraud.update');
    Route::delete('merchant/fraud/delete/{id}',                  [MerchantPanelFraudController::class, 'destroy'])->name('merchant-panel.fraud.delete');
    Route::get('merchant/fraud/filter',                          [MerchantPanelFraudController::class, 'filter'])->name('merchant-panel.fraud.filter');
    Route::post('merchant/fraud/check',                          [MerchantPanelFraudController::class, 'check'])->name('merchant-panel.fraud.check');

    //reports
    Route::get('merchant/reports/closing',                       [ReportsController::class, 'closingReports'])->name('merchant.report.closing');

    //pickup request
    Route::post('merchant/pickup-request/regular',               [PickupRequestController::class, 'regularStore'])->name('merchant.panel.pickup.request.regular.store');
    Route::post('merchant/pickup-request/express',               [PickupRequestController::class, 'expressStore'])->name('merchant.panel.pickup.request.express.store');
});

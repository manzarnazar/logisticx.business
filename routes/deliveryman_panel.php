<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\ParcelController;
use App\Http\Controllers\Backend\DeliverymanPanel\ReportController;
use App\Http\Controllers\Backend\DeliverymanPanel\DashboardController;

Route::middleware(['isInstalled', 'auth', 'XSS'])->group(function () {

    Route::get('deliveryman/parcel/details/{id}',           [ParcelController::class, 'details'])->name('deliveryman.panel.parcel.details');
    Route::get('deliveryman/parcel/logs/{id}',              [ParcelController::class, 'logs'])->name('deliveryman.panel.parcel.logs');
    Route::post('deliveryman/request/parcel/delivery',      [ParcelController::class, 'requestParcelDelivery'])->name('hero.requestParcelDelivery');

    Route::post('deliveryman/parcel/received-warehouse',    [DashboardController::class, 'receivedWarehouse'])->name('deliveryman.panel.parcel.received.warehouse');
    Route::post('deliveryman/parcel/delivered',             [DashboardController::class, 'delivered'])->name('deliveryman.panel.parcel.delivered');
    Route::post('deliveryman/parcel/partial-delivered',     [DashboardController::class, 'partialDelivered'])->name('deliveryman.panel.parcel.partial.delivered');
    Route::post('deliveryman/parcel/return-to-courier',     [DashboardController::class, 'returnToCourier'])->name('deliveryman.panel.parcel.return.to.courier');

    Route::get('deliveryman/reports/closing-report',        [ReportController::class, 'closingReports'])->name('deliveryman.panel.reports.closing.report');
});

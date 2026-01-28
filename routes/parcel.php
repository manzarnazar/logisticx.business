<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\ParcelController;
use App\Http\Controllers\Backend\HubInChargeController;


Route::middleware(['isInstalled', 'XSS', 'auth'])->group(function () {


    // Parcel Routes
    Route::get('parcel/index/{slug?}',                               [ParcelController::class, 'index'])->name('parcel.index')->middleware('hasPermission:parcel_read');
    Route::get('parcel/index/details/{id}',                           [ParcelController::class, 'details'])->name('parcel.details')->middleware('hasPermission:parcel_details_read');
    Route::get('parcel/index/create/parcel',                                 [ParcelController::class, 'create'])->name('parcel.create')->middleware('hasPermission:parcel_create');
    Route::post('parcel/store',                                 [ParcelController::class, 'store'])->name('parcel.store')->middleware('hasPermission:parcel_create');
    Route::get('parcel/index/edit/{id}',                              [ParcelController::class, 'edit'])->name('parcel.edit')->middleware('hasPermission:parcel_update');
    Route::put('parcel/update/',                                [ParcelController::class, 'update'])->name('parcel.update')->middleware('hasPermission:parcel_update');
    Route::get('merchant/parcel-bank/index/parcel/clone/{id}',                             [ParcelController::class, 'duplicate'])->name('parcel.clone')->middleware('hasPermission:parcel_create');
    Route::delete('parcel/delete/{id}',                         [ParcelController::class, 'destroy'])->name('parcel.delete')->middleware('hasPermission:parcel_delete');
    Route::get('parcel/print/{id}',                             [ParcelController::class, 'parcelPrint'])->name('parcel.print')->middleware('hasPermission:parcel_read');
    Route::get('parcel/print/label/{id}',                       [ParcelController::class, 'parcelPrintLabel'])->name('parcel.print-label')->middleware('hasPermission:parcel_read');

    Route::post('admin/parcel/deliveryman/search',              [ParcelController::class, 'deliverymanSearch'])->name('parcel.deliveryman.search');

    //parcel status
    Route::post('admin/parcel/pickup-man/assigned',             [ParcelController::class, 'PickupManAssigned'])->name('parcel.pickup.man-assigned')->middleware('hasPermission:parcel_status_update');
    Route::post('admin/parcel/pickup/re-schedule',              [ParcelController::class, 'PickupReSchedule'])->name('parcel.pickup.re.schedule')->middleware('hasPermission:parcel_status_update');
    Route::post('admin/parcel/pickup/received',                 [ParcelController::class, 'receivedByPickupMan'])->name('parcel.received.by.pickup')->middleware('hasPermission:parcel_status_update');
    Route::post('admin/parcel/received-warehouse',              [ParcelController::class, 'receivedWarehouse'])->name('parcel.received.warehouse')->middleware('hasPermission:parcel_status_update');

    // Route::post('parcel/search',                                [ParcelController::class, 'searchParcel'])->name('parcel.search');

    Route::get('admin/parcel/filter',                           [ParcelController::class, 'filter'])->name('parcel.filter')->middleware('hasPermission:parcel_read');
    Route::post('parcel/search/hub-transfer',                          [ParcelController::class, 'searchForHUbTransfer'])->name('parcel.searchForHUbTransfer');
    Route::post('parcel/search/for-bulk-hero-assign',                          [ParcelController::class, 'searchForBulkHeroAssign'])->name('parcel.searchForBulkHeroAssign');
    // Route::post('admin/parcel/search-expense',                  [ParcelController::class, 'searchExpense'])->name('parcel.search-expense');
    // Route::post('admin/parcel/search-income',                   [ParcelController::class, 'searchIncome'])->name('parcel.search-income');

    //ajax route for fetching parcels
    Route::post('/parcel/cash-collect-by-delivery-man',                     [ParcelController::class, 'parcelsCashCollectByDeliveryMan'])->name('parcel.cashCollectByDeliveryMan');
    Route::post('/parcel/cash-in-hub',                                      [ParcelController::class, 'parcelsCashInHub'])->name('parcel.cashInHub');
    Route::post('/parcel/unpaid-charge-by-merchant',                        [ParcelController::class, 'parcelsChargeUnpaid'])->name('parcel.chargeUnpaid');
    Route::post('/parcel/unpaid-hero-commission',                           [ParcelController::class, 'parcelsUnpaidHeroCommission'])->name('parcel.unpaidHeroCommission');

    Route::post('parcel/transfer/multiple/to-hub',                          [ParcelController::class, 'transferToHubMultipleParcel'])->name('parcel.transfer-to-hub-multiple-parcel')->middleware('hasPermission:parcel_status_update');
    Route::post('parcel/assign/hero/multiple',                              [ParcelController::class, 'deliveryManAssignMultipleParcel'])->name('parcel.assign.hero.multiple')->middleware('hasPermission:parcel_status_update');
    Route::post('admin/parcel/transfer-to-hub',                             [ParcelController::class, 'transferToHub'])->name('parcel.transfer-to-hub')->middleware('hasPermission:parcel_status_update');
    Route::post('admin/parcel/transfer-hub',                                [ParcelController::class, 'transferHub'])->name('parcel.transferHub')->middleware('hasPermission:parcel_status_update');
    Route::post('admin/parcel/received-by-hub',                             [ParcelController::class, 'receivedByHub'])->name('parcel.received-by.hub')->middleware('hasPermission:parcel_status_update');
    Route::post('parcel/received/warehouse/hub-selected',                   [ParcelController::class, 'warehouseHubSelected'])->name('parcel.received.warehouse.hub.select');
    Route::post('admin/parcel/delivery-man-assign',                         [ParcelController::class, 'deliverymanAssign'])->name('parcel.delivery-man-assign')->middleware('hasPermission:parcel_status_update');
    Route::get('admin/parcel/bulk-assign/print',                            [ParcelController::class, 'ParcelBulkAssignPrint'])->name('parcel.parcel-bulkassign-print');
    Route::post('admin/parcel/delivery-reschedule',                         [ParcelController::class, 'deliveryReschedule'])->name('parcel.delivery.reschedule')->middleware('hasPermission:parcel_status_update');
    Route::post('admin/parcel/return-to-courier',                           [ParcelController::class, 'returnToCourier'])->name('parcel.return-to-qourier')->middleware('hasPermission:parcel_status_update');

    Route::post('admin/parcel/return-assign-to-merchant',                   [ParcelController::class, 'returnAssignToMerchant'])->name('parcel.return-assign-to-merchant')->middleware('hasPermission:parcel_status_update');
    Route::post('admin/parcel/assign/return/to-merchant/reschedule',        [ParcelController::class, 'returnAssignToMerchantReschedule'])->name('parcel.return-assign-to-merchant.reschedule')->middleware('hasPermission:parcel_status_update');
    Route::post('admin/parcel/return-received-by-merchant',                 [ParcelController::class, 'returnReceivedByMerchant'])->name('parcel.return-received-by-merchant')->middleware('hasPermission:parcel_status_update');
    Route::post('admin/parcel/delivered',                                   [ParcelController::class, 'parcelDelivered'])->name('parcel.delivered')->middleware('hasPermission:parcel_status_update');
    Route::post('admin/parcel/partial-delivered',                           [ParcelController::class, 'parcelPartialDelivered'])->name('parcel.partial-delivered')->middleware('hasPermission:parcel_status_update');
    Route::post('admin/parcel/transfer-to-hub-selected-hub',                [ParcelController::class, 'transferToHubSelectedHub'])->name('transertohub.selected.hub');
    Route::post('admin/parcel/received-by-multiple-hub',                    [ParcelController::class, 'parcelReceivedByMultipleHub'])->name('parcel.received-by-mulbiple-hub')->middleware('hasPermission:parcel_status_update');

    Route::post('admin/parcel/received-by-hub/search',                      [ParcelController::class, 'parcelReceivedByHubSearch'])->name('parcel.received-by-hub-search'); //ajax

    Route::post('admin/parcel/assign-pickup/search',                        [ParcelController::class, 'AssignPickupParcelSearch'])->name('assign-pickup.parcel.search'); //ajax
    Route::post('admin/parcel/assign-pickup/bulk',                          [ParcelController::class, 'AssignPickupBulk'])->name('parcel.assign-pickup-bulk')->middleware('hasPermission:parcel_status_update');

    Route::post('admin/parcel/assign-return-to-merchant/search',            [ParcelController::class, 'AssignReturnToMerchantParcelSearch'])->name('assign-return-to-merchant.parcel.search'); //ajax
    Route::post('admin/parcel/assign-return-to-merchant-bulk',              [ParcelController::class, 'AssignReturnToMerchantBulk'])->name('parcel.assign-return-to-merchant-bulk')->middleware('hasPermission:parcel_status_update');
    //end parcel status

    // parcel status cancel urls
    Route::get('parcel/{id}/pickup-man/assigned/cancel',                   [ParcelController::class, 'PickupManAssignedCancel'])->name('parcel.pickup.man-assigned-cancel')->middleware('hasPermission:parcel_status_update');
    Route::get('parcel/{id}/pickup/received/cancel',                       [ParcelController::class, 'receivedByPickupManCancel'])->name('parcel.pickup.man-received-cancel')->middleware('hasPermission:parcel_status_update');
    Route::get('parcel/{id}/pickup-reschedule/cancel',                     [ParcelController::class, 'PickupReScheduleCancel'])->name('parcel.pickup.re-schedule-cancel')->middleware('hasPermission:parcel_status_update');
    Route::get('parcel/{id}/received-warehouse/cancel',                    [ParcelController::class, 'receivedWarehouseCancel'])->name('parcel.received-warehouse-cancel')->middleware('hasPermission:parcel_status_update');
    Route::get('parcel/{id}/delivery-man/assign/cancel',                   [ParcelController::class, 'deliverymanAssignCancel'])->name('parcel.delivery-man-assign-cancel')->middleware('hasPermission:parcel_status_update');
    Route::get('parcel/{id}/delivery-re-schedule/cancel',                  [ParcelController::class, 'deliveryReScheduleCancel'])->name('parcel.delivery-re-schedule-cancel')->middleware('hasPermission:parcel_status_update');
    Route::get('parcel/{id}/partial-delivered/cancel',                     [ParcelController::class, 'parcelPartialDeliveredCancel'])->name('parcel.partial-delivered-cancel')->middleware('hasPermission:parcel_status_update');
    Route::get('parcel/{id}/transfer-to-hub/cancel',                       [ParcelController::class, 'transferToHubCancel'])->name('parcel.transfer-to-hub-cancel')->middleware('hasPermission:parcel_status_update');
    Route::get('parcel/{id}/received-by-hub/cancel',                       [ParcelController::class, 'receivedByHubCancel'])->name('parcel.received-by-hub-cancel')->middleware('hasPermission:parcel_status_update');
    Route::get('parcel/{id}/return-to-courier-cancel',                     [ParcelController::class, 'returnToCourierCancel'])->name('parcel.return-to-courier-cancel')->middleware('hasPermission:parcel_status_update');
    Route::get('parcel/{id}/return-assign-to-merchant/cancel',             [ParcelController::class, 'returnAssignToMerchantCancel'])->name('parcel.return-assign-to-merchant-cancel')->middleware('hasPermission:parcel_status_update');
    Route::get('parcel/{id}/return/assign/reschedule/to-merchant/cancel',  [ParcelController::class, 'returnAssignToMerchantRescheduleCancel'])->name('parcel.return-assign-re-schedule-to-merchant-cancel')->middleware('hasPermission:parcel_status_update');
    Route::get('parcel/{id}/return-received-by-merchant/cancel',           [ParcelController::class, 'returnReceivedByMerchantCancel'])->name('parcel.return-received-by-merchant-cancel')->middleware('hasPermission:parcel_status_update');
    Route::get('parcel/{id}/delivered/cancel',                             [ParcelController::class, 'parcelDeliveredCancel'])->name('parcel.delivered-cancel')->middleware('hasPermission:parcel_status_update');
    // end parcel status cancel urls

    Route::post('admin/parcel/hub-incharge',                                [HubInChargeController::class, 'hubInchargeSearch'])->name('hub.incharge.search');

    Route::post('admin/parcel/merchant',                                    [ParcelController::class, 'getMerchant'])->name('parcel.merchant.get');
    Route::post('admin/parcel/merchant/shops',                              [ParcelController::class, 'merchantShops'])->name('parcel.merchant.shops');
    Route::post('admin/parcel/merchant/service-type',                       [ParcelController::class, 'serviceType'])->name('parcel.serviceType')->withoutMiddleware(['auth']);
    Route::post('admin/parcel/merchant/charge',                             [ParcelController::class, 'charge'])->name('parcel.merchant.charge')->withoutMiddleware(['auth']);
    Route::post('admin/parcel/hub',                                         [ParcelController::class, 'getHub'])->name('parcel.hub.get');

    //import
    Route::get('parcel/index/import/view',                    [ParcelController::class, 'parcelImportView'])->name('parcel.importView')->middleware('hasPermission:parcel_create');
    Route::post('parcel/index/import',                   [ParcelController::class, 'parcelImport'])->name('parcel.import')->middleware('hasPermission:parcel_create');
    Route::get('parcel/index/import/sample',             [ParcelController::class, 'parcelImportSample'])->name('parcel.importSample')->middleware('hasPermission:parcel_create');

    //parcel search
    Route::get('admin/parcel/specific/search',      [ParcelController::class, 'ParcelSearch'])->name('parcel.specific.search');
    //merchant fetch using ajax
    Route::post('admin/parcel/get-merchant-cod',    [parcelController::class, 'getMerchantCod'])->name('get.merchant.cod');

    Route::get('parcel/bookmark/toggle/{id}',       [ParcelController::class, 'parcelBankToggle'])->name('parcelBankToggle');
});

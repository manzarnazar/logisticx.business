<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HeroAppController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\Api\MerchantAppController;
use App\Http\Controllers\Api\MerchantShopController;
use App\Http\Controllers\Api\MerchantAccountController;
use App\Http\Controllers\Api\MerchantSupportController;
use App\Http\Controllers\Api\MerchantAppChargesController;
use App\Http\Controllers\Api\MerchantAppReportsController;
use App\Http\Controllers\Api\PickupRequestApiController;
use App\Http\Controllers\Api\MerchantAppPaymentRequestController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Merchant App
Route::post('/login-merchant',                                  [AuthController::class, 'merchantLogin']);
Route::post('/signup-merchant',                                 [AuthController::class, 'merchantSignUpStore']);
Route::post('/merchant-email-verification',                     [AuthController::class, 'merchantEmailVerification']);
Route::post('/merchant-forgot-password',                        [AuthController::class, 'forgotPassword']);
Route::post('/merchant-reset-password',                         [AuthController::class, 'resetPassword']);

// Deliveryman App
Route::post('/login',                                           [AuthController::class, 'login']);
Route::post('/forgot-password',                                 [AuthController::class, 'forgotPassword']);
Route::post('/reset-password',                                  [AuthController::class, 'resetPassword']);

Route::get('app-languages',                                     [SettingsController::class, 'appLanguages']);
Route::get('app-language/terms',                                [SettingsController::class, 'languageTerms']);
Route::get('localization/{language}',                           [SettingsController::class, 'setLocalization']);

Route::get('app-slider',                                        [SettingsController::class, 'appSlider']);
Route::get('settings',                                          [SettingsController::class, 'settings']);
Route::get('hub-list',                                          [MerchantAppController::class, 'hubList']);


// delivery man api
Route::group(['middleware' => ['auth:api']], function () {
    Route::post('logout',                                       [AuthController::class, 'logout']);
    Route::post('update-password',                              [AuthController::class, 'updatePassword']);
    Route::get('profile',                                       [AuthController::class, 'profile']);
    Route::post('profile/update',                               [AuthController::class, 'updateProfile']);


    Route::get('parcels/{status?}',                             [HeroAppController::class, 'parcels']);
    Route::post('parcel',                                       [HeroAppController::class, 'singleParcel']);

    Route::post('parcel/request/update/status',                 [HeroAppController::class, 'requestParcelDelivery']);
    Route::post('parcel/confirm/update/status',                 [HeroAppController::class, 'ConfirmParcelDelivery']);

    Route::get('hero/dashboard',                                [HeroAppController::class, 'dashboardData']);
    Route::get('hero/payments/{payment_status?}',               [HeroAppController::class, 'heroPayments']);
    Route::get('hero/cod-collections',                          [HeroAppController::class, 'codCollections']);

    Route::get('notifications',                                 [HeroAppController::class, 'notifications']);
});


// merchant api
Route::group(['middleware' => ['auth:api']], function () {
    Route::get('merchant-profile',                              [MerchantAppController::class, 'profile']);
    Route::post('merchant/profile/update',                      [AuthController::class, 'updateMerchantProfile']);
    Route::post('merchant/password/update',                     [MerchantAppController::class, 'merchantPassUpdate']);

    //Hub-list for shops create
    Route::get('merchant/hub-list',                             [MerchantAppController::class, 'hubList']);
    Route::get('merchant/bank-list',                            [MerchantAccountController::class, 'bankList']);

    //Merchant shop - list or Pickup points
    Route::get('merchant/shops',                               [MerchantShopController::class, 'shopList']);
    Route::post('merchant/shop/store',                         [MerchantShopController::class, 'shopCreate']);
    Route::get('merchant/shop/edit/{id}',                      [MerchantShopController::class, 'getShopForEdit']);
    Route::post('merchant/shop/update',                           [MerchantShopController::class, 'updateShop']);
    Route::post('merchant/shop/default-shop/{shop_id}',         [MerchantShopController::class, 'defaultShop']);
    Route::delete('merchant/shop/delete/{id}',                  [MerchantShopController::class, 'deleteShop']);

    // Merchant accounts CRUD
    Route::get('merchant/payment-accounts',                     [MerchantAccountController::class, 'paymentAccounts']);
    Route::post('merchant/payment-account/store',               [MerchantAccountController::class, 'createPaymentAccount']);
    Route::get('merchant/payment-account/edit/{id}',            [MerchantAccountController::class, 'getPaymentAccountForEdit']);
    Route::post('merchant/payment-account/update',              [MerchantAccountController::class, 'updatePaymentAccount']);
    Route::delete('merchant/payment-account/delete/{id}',       [MerchantAccountController::class, 'deletePaymentAccount']);
    Route::get('merchant/payment-account/configs',              [MerchantAccountController::class, 'paymentAccountConfigs']);

    //Merchant Payment Request CRUD
    Route::get('merchant/payment-requests',                     [MerchantAppPaymentRequestController::class, 'paymentRequests']);
    Route::get('merchant/payment-request/parcels/{requestId?}', [MerchantAppPaymentRequestController::class, 'getParcelsForRequestPayment']);
    Route::get('merchant/payment-accounts/{merchant_id}',       [MerchantAppPaymentRequestController::class, 'specificMerchantAccounts']);
    Route::get('merchant/payment-request/view/{id}',            [MerchantAppPaymentRequestController::class, 'view']);
    Route::post('merchant/payment-request/store',               [MerchantAppPaymentRequestController::class, 'createPaymentRequest']);
    Route::get('merchant/payment-request/edit/{id}',            [MerchantAppPaymentRequestController::class, 'getPaymentRequestForEdit']);
    Route::post('merchant/payment-request/update',              [MerchantAppPaymentRequestController::class, 'updatePaymentRequest']);
    Route::delete('merchant/payment-request/delete/{id}',       [MerchantAppPaymentRequestController::class, 'deletePaymentRequest']);

    // Parcel Crud Operations
    Route::get('merchant/parcels/{status?}',                   [MerchantAppController::class, 'parcels']);
    Route::post('merchant/parcel/store',                       [MerchantAppController::class, 'createParcel']);
    Route::get('merchant/parcel/edit/{id}',                     [MerchantAppController::class, 'editParcel']);
    Route::post('merchant/parcel/update',                       [MerchantAppController::class, 'updateParcel']);
    Route::delete('merchant/parcel/delete/{id}',                [MerchantAppController::class, 'deleteParcel']);

    Route::get('merchant/parcel-list',                          [MerchantAppController::class, 'merchantParcelList']);
    Route::get('merchant/parcel-detail/{id}',                   [MerchantAppController::class, 'parcelDetails']);
    Route::get('merchant/parcel-events/{id}',                   [MerchantAppController::class, 'parcelEvents']);
    Route::get('merchant/parcel-bank',                          [MerchantAppController::class, 'parcelBank']);
    Route::get('merchant/pickup-point/info/{shopId}',           [MerchantAppController::class, 'pickupPointNumAndAddress']);
    Route::get('merchant/parcel/coverages',                     [MerchantAppController::class, 'coverages']);
    Route::get('merchant/parcel/vas',                           [MerchantAppController::class, 'valueAddedService']);
    Route::get('merchant/parcel/product-categories',            [MerchantAppController::class, 'productCategories']);
    Route::post('merchant/parcel/service-type',                  [MerchantAppController::class, 'serviceTypes']);
    Route::post('merchant/parcel/get-charge',                    [MerchantAppController::class, 'getCharge']);

    // charges
    Route::get('merchant/general-charges',                 [MerchantAppChargesController::class, 'generalCharges']);
    Route::get('merchant/my-charges',                      [MerchantAppChargesController::class, 'myCharges']);
    Route::get('merchant/charges/cod-others',              [MerchantAppChargesController::class, 'merchantCodAndOtherCharges']);

    // parcel reports
    Route::get('merchant/reports/parcel-status-list',           [MerchantAppReportsController::class, 'parcelStatusList']);
    Route::post('merchant/reports/parcel-status',               [MerchantAppReportsController::class, 'parcelSReports']);
    
    Route::post('merchant/reports/closing-report',              [MerchantAppReportsController::class, 'closingReports']);
    Route::post('merchant/reports/account-transaction/filter',  [MerchantAppReportsController::class, 'accountTransactionListFilter']);

    //pickup request
    Route::get('merchant/pickup-requests', [PickupRequestApiController::class, 'index']);
    Route::post('merchant/pickup-requests', [PickupRequestApiController::class, 'store']);
    Route::delete('merchant/pickup-request/delete/{id}', [PickupRequestApiController::class, 'delete']);

    Route::get('merchant/supports',                             [MerchantSupportController::class, 'allSupports']);
    Route::get('merchant/supports/get-departments',             [MerchantSupportController::class, 'getDepartments']);
    Route::get('merchant/supports/configs',                     [MerchantSupportController::class, 'supportConfigs']);
    Route::post('merchant/support/store',                       [MerchantSupportController::class, 'createSupport']);
    Route::post('merchant/support/update',                      [MerchantSupportController::class, 'updateSupport']);
    Route::get('merchant/support/edit/{id}',                    [MerchantSupportController::class, 'editSupport']);
    Route::get('merchant/support/view/{id}',                    [MerchantSupportController::class, 'viewSupport']);
    Route::delete('merchant/support/delete/{id}',               [MerchantSupportController::class, 'deleteSupport']);

    Route::get('merchant/notifications',                                [MerchantAppController::class, 'notifications']);
    Route::post('merchant/notification/{id}/read',                      [MerchantAppController::class, 'notificationMarkAsRead']);
    Route::post('merchant/notification/read-all',                       [MerchantAppController::class, 'notificationMarkAllAsRead']);
    Route::get('merchant/notifications/unread-count',                   [MerchantAppController::class, 'unreadNotificationCount']);

    Route::get('merchant/home-stats',                                  [MerchantAppController::class, 'homeStats']);


});

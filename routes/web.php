<?php

use App\Http\Middleware\XSS;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\InstallerController;
use App\Http\Controllers\RouteListController;
use App\Http\Controllers\Backend\TodoController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\Backend\FraudController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\Backend\SupportController;
use App\Http\Controllers\Backend\ActiveLogController;
use App\Http\Controllers\Backend\AppSliderController;
use App\Http\Controllers\Backend\CustomerInquiryController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\DeliveryManController;
use App\Http\Controllers\Backend\HubInChargeController;
use App\Http\Controllers\Backend\LocalizationController;
use App\Http\Controllers\Backend\MerchantShopsController;
use App\Http\Controllers\Backend\UserRole\UserController;
use App\Http\Controllers\Backend\WebNotificationController;
use App\Http\Controllers\Backend\PushNotificationController;
use App\Http\Controllers\Backend\Setting\SocialLoginController;
use App\Http\Controllers\Backend\MerchantPaymentAccountController;


Route::get('cache-clear', function () {
    Artisan::call('optimize:clear');

    return redirect()->back()->with('success', ___('alert.cache_successfully_cleared.'));
    // dd('success');
});

//installer
// Route::middleware(['XSS','IsNotInstalled'])->group(function(){
//     Route::get('install',                     [InstallerController::class,'index']);
// });
// Route::middleware(['XSS'])->group(function(){
//     Route::post('installing',                      [InstallerController::class,'installing'])->name('installing');
//     Route::get('finish',                           [InstallerController::class,'finish'])->name('final');
// });

//end installer

Route::middleware(['isInstalled', 'XSS'])->group(function () {

    Route::get('localization/{language}',                       [LocalizationController::class, 'setLocalization'])->name('setlocalization');

    Auth::routes();

    //social authentication
    Route::get('/login/{social}',                               [SocialLoginController::class, 'socialRedirect'])->name('social.login');
    Route::get('/google/login',                                 [SocialLoginController::class, 'authGoogleLogin']); //google login , need url add in  your google app
    Route::get('/facebook/login',                               [SocialLoginController::class, 'authFacebookLogin']); // facebook login, need url add in your facebook app



    Route::middleware(['auth'])->group(function () {

        // user consents
        Route::put('cookie-consent',                                [UserController::class, 'cookieConsent'])->name('user.cookieConsent');

        //Dashboard
        Route::get('/dashboard',                                    [DashboardController::class, 'index'])->name('dashboard.index');
        Route::post('dashboard/parcel-30-day-status',               [DashboardController::class, 'parcel30DayStatus'])->name('parcel30DayStatus');
        Route::post('dashboard/parcel-7-day-income-expense',        [DashboardController::class, 'courier7DayIncomeExpense'])->name('courier7DayIncomeExpense');
        Route::post('dashboard/merchant-charge-7-day',              [DashboardController::class, 'dailyMerchantCharge'])->name('dailyMerchantCharge');
        Route::post('dashboard/hero-commission-7-day',              [DashboardController::class, 'hero7DayCommission'])->name('hero7DayCommission');
        Route::post('dashboard/cash-collection-7-day',              [DashboardController::class, 'cod7day'])->name('cod7day');

        // profile
        Route::get('profile',                                       [ProfileController::class, 'profile'])->name('profile');
        Route::get('profile/update',                                [ProfileController::class, 'profileEdit'])->name('profile.update');
        Route::put('profile/update',                                [ProfileController::class, 'profileUpdate'])->name('profile.update');
        Route::get('password/update',                               [ProfileController::class, 'passwordEdit'])->name('password.update');
        Route::put('password/update',                               [ProfileController::class, 'passwordUpdate'])->name('password.update');

        // Admin Routes
        Route::get('admin/logs',                                    [ActiveLogController::class, 'index'])->name('logs.index')->middleware('hasPermission:log_read');
        Route::get('admin/log-activity-view/{id}',                  [ActiveLogController::class, 'view'])->name('log-activity-view');

        // Hub in charges
        Route::get('hub/in-charge/index/{hubID}',                   [HubInChargeController::class, 'index'])->name('hub-incharge.index')->middleware('hasPermission:hub_incharge_read');
        Route::get('hub/in-charge/create/{hubID}',                  [HubInChargeController::class, 'create'])->name('hub-incharge.create')->middleware('hasPermission:hub_incharge_create');
        Route::post('hub/in-charge/{hubID}/store',                  [HubInChargeController::class, 'store'])->name('hub-incharge.store')->middleware('hasPermission:hub_incharge_create');
        Route::get('hub/in-charge/edit/{hubID}/{id}',                [HubInChargeController::class, 'edit'])->name('hub-incharge.edit')->middleware('hasPermission:hub_incharge_update');
        Route::put('hub/in-charge/{hubID}/update/{id}',              [HubInChargeController::class, 'update'])->name('hub-incharge.update')->middleware('hasPermission:hub_incharge_update');
        Route::delete('hub/in-charge/{hubID}/delete/{id}',           [HubInChargeController::class, 'destroy'])->name('hub-incharge.destroy')->middleware('hasPermission:hub_incharge_delete');
        Route::get('hub/in-charge/{hubID}/assigned/{id}',            [HubInChargeController::class, 'assigned'])->name('hub-incharge.assigned')->middleware('hasPermission:hub_incharge_assigned');

        //Merchant shops routes
        Route::get('admin/merchant/{id}/shops/index',                [MerchantShopsController::class, 'index'])->name('merchant.shops.index')->middleware('hasPermission:merchant_shop_read');
        Route::get('admin/merchant/shops/create/{id}',               [MerchantShopsController::class, 'create'])->name('merchant.shops.create')->middleware('hasPermission:merchant_shop_create');
        Route::post('admin/merchant/shops/store',                    [MerchantShopsController::class, 'store'])->name('merchant.shops.store')->middleware('hasPermission:merchant_shop_create');
        Route::get('admin/merchant/shops/edit/{id}',                 [MerchantShopsController::class, 'edit'])->name('merchant.shops.edit')->middleware('hasPermission:merchant_shop_update');
        Route::put('admin/merchant/shops/update',                    [MerchantShopsController::class, 'update'])->name('merchant.shops.update')->middleware('hasPermission:merchant_shop_update');
        Route::delete('admin/merchant/shops/delete/{id}',            [MerchantShopsController::class, 'delete'])->name('merchant.shops.delete')->middleware('hasPermission:merchant_shop_delete');
        Route::get('admin/merchant/shops/default/{merchant_id}/{id}', [MerchantShopsController::class, 'defaultShop'])->name('merchant.shops.default');

        //merchant payment account
        Route::get('merchant/{merchant_id}/payment/account/index',           [MerchantPaymentAccountController::class, 'index'])->name('merchant.paymentInfo.index')->middleware('hasPermission:merchant_payment_account_read');
        Route::get('merchant/{merchant_id}/payment/account/add',             [MerchantPaymentAccountController::class, 'create'])->name('merchant.paymentInfo.add')->middleware('hasPermission:merchant_payment_account_create');
        Route::post('merchant/payment/account/store',                        [MerchantPaymentAccountController::class, 'store'])->name('merchant.payment.account.store')->middleware('hasPermission:merchant_payment_account_create');
        Route::get('merchant/{merchant_id}/payment/edit/{id}',               [MerchantPaymentAccountController::class, 'edit'])->name('merchant.paymentInfo.edit')->middleware('hasPermission:merchant_payment_account_update');
        Route::put('merchant/payment/account/update',                        [MerchantPaymentAccountController::class, 'update'])->name('merchant.payment.account.update')->middleware('hasPermission:merchant_payment_account_update');
        Route::delete('merchant/payment/account/delete/{id}',                [MerchantPaymentAccountController::class, 'delete'])->name('merchant.payment.account.delete')->middleware('hasPermission:merchant_payment_account_delete');

        // Deliveryman
        Route::get('admin/deliveryman',                   [DeliveryManController::class, 'index'])->name('deliveryman.index')->middleware('hasPermission:delivery_man_read');
        Route::get('admin/deliveryman/filter',            [DeliveryManController::class, 'filter'])->name('deliveryman.filter')->middleware('hasPermission:delivery_man_read');
        Route::get('admin/deliveryman/create',            [DeliveryManController::class, 'create'])->name('deliveryman.create')->middleware('hasPermission:delivery_man_create');
        Route::post('admin/deliveryman/store',            [DeliveryManController::class, 'store'])->name('deliveryman.store')->middleware('hasPermission:delivery_man_create');
        Route::get('admin/deliveryman/edit/{id}',         [DeliveryManController::class, 'edit'])->name('deliveryman.edit')->middleware('hasPermission:delivery_man_update');
        Route::put('admin/deliveryman/update',            [DeliveryManController::class, 'update'])->name('deliveryman.update')->middleware('hasPermission:delivery_man_update');
        Route::delete('admin/deliveryman/delete/{id}',    [DeliveryManController::class, 'destroy'])->name('deliveryman.delete')->middleware('hasPermission:delivery_man_delete');
        Route::post('delivery-man/search',                [DeliveryManController::class, 'searchDeliveryMan'])->name('deliveryman.search');

        // Fraud
        Route::get('admin/fraud',                         [FraudController::class, 'index'])->name('fraud.index')->middleware('hasPermission:fraud_read');
        Route::get('admin/fraud/create',                  [FraudController::class, 'create'])->name('fraud.create')->middleware('hasPermission:fraud_create');
        Route::post('admin/fraud/store',                  [FraudController::class, 'store'])->name('fraud.store')->middleware('hasPermission:fraud_create');
        Route::get('admin/fraud/edit/{id}',               [FraudController::class, 'edit'])->name('fraud.edit')->middleware('hasPermission:fraud_update');
        Route::put('admin/fraud/update',                  [FraudController::class, 'update'])->name('fraud.update')->middleware('hasPermission:fraud_update');
        Route::delete('admin/fraud/delete/{id}',          [FraudController::class, 'destroy'])->name('fraud.delete')->middleware('hasPermission:fraud_delete');

        // To_do List route
        Route::get('todo/index',                          [TodoController::class, 'index'])->name('todo.index')->middleware('hasPermission:todo_read');
        Route::post('todo/todo_add',                      [TodoController::class, 'store'])->name('todo.store')->middleware('hasPermission:todo_create');
        Route::post('todo/modal',                         [TodoController::class, 'todoModal'])->name('todo.modal');
        Route::post('todo/processing',                    [TodoController::class, 'todoProcessing'])->name('todo.processing')->middleware('hasPermission:todo_update');
        Route::post('todo/completed',                     [TodoController::class, 'todoComplete'])->name('todo.completed')->middleware('hasPermission:todo_update');
        Route::put('todo/update',                         [TodoController::class, 'update'])->name('todo.update')->middleware('hasPermission:todo_update');
        Route::delete('todo/delete/{id}',                 [TodoController::class, 'destroy'])->name('todo.delete')->middleware('hasPermission:todo_delete');

        // Contact Us
        Route::get('admin/contact-us/inbox',              [ContactUsController::class, 'index'])->name('contactUs.index');

        // Support route
        Route::get('support/index',                 [SupportController::class, 'index'])->name('support.index')->middleware('hasPermission:support_read');
        Route::get('support/index/view/{id}',             [SupportController::class, 'view'])->name('support.view');
        Route::get('support/index/create',                [SupportController::class, 'create'])->name('support.add')->middleware('hasPermission:support_create');
        Route::post('support/store',                [SupportController::class, 'store'])->name('support.store')->middleware('hasPermission:support_create');
        Route::get('support/index/edit/{id}',             [SupportController::class, 'edit'])->name('support.edit')->middleware('hasPermission:support_update');
        Route::put('support/update',                [SupportController::class, 'update'])->name('support.update')->middleware('hasPermission:support_update');
        Route::delete('support/delete/{id}',        [SupportController::class, 'destroy'])->name('support.delete')->middleware('hasPermission:support_delete');
        Route::post('support/reply',                [SupportController::class, 'supportReply'])->name('support.reply')->middleware('hasPermission:support_reply');


        // push-notification
        Route::get('admin/push-notification',                         [PushNotificationController::class, 'index'])->name('push-notification.index')->middleware('hasPermission:push_notification_read');
        Route::get('admin/push-notification/create',                  [PushNotificationController::class, 'create'])->name('push-notification.create')->middleware('hasPermission:push_notification_create');
        Route::post('admin/push-notification/store',                  [PushNotificationController::class, 'store'])->name('push-notification.store')->middleware('hasPermission:push_notification_create');
        Route::delete('admin/push-notification/delete/{id}',          [PushNotificationController::class, 'destroy'])->name('push-notification.delete')->middleware('hasPermission:push_notification_delete');

        Route::get('notifications',                         [NotificationController::class, 'index'])->name('notification.index');

        // route search functionality
        Route::get('search',                                [RouteListController::class, 'search'])->name('search');
        Route::post('search/routes',                        [RouteListController::class, 'searchRoute'])->name('search.route');

        // FCM Token
        Route::post('/store-token',                         [WebNotificationController::class, 'store'])->name('notification-store.token');


        // app slider
        Route::get('admin/app-slider',                         [AppSliderController::class, 'index'])->name('app_slider.index')->middleware('hasPermission:app_slider_read');
        Route::get('admin/app-slider/create',                  [AppSliderController::class, 'create'])->name('app_slider.create')->middleware('hasPermission:app_slider_create');
        Route::post('admin/app-slider/store',                  [AppSliderController::class, 'store'])->name('app_slider.store')->middleware('hasPermission:app_slider_create');
        Route::get('admin/app-slider/edit/{id}',               [AppSliderController::class, 'edit'])->name('app_slider.edit')->middleware('hasPermission:app_slider_update');
        Route::put('admin/app-slider/update',                  [AppSliderController::class, 'update'])->name('app_slider.update')->middleware('hasPermission:app_slider_update');
        Route::delete('admin/app-slider/delete/{id}',          [AppSliderController::class, 'delete'])->name('app_slider.delete')->middleware('hasPermission:app_slider_delete');

        // Customer inquiry
        Route::get('admin/customer-inquiry/index',             [CustomerInquiryController::class, 'index'])->name('customer_inquiry.index')->middleware('hasPermission:customer_inquiry_read');
        Route::get('admin/customer-inquiry/view/{id}',         [CustomerInquiryController::class, 'view'])->name('customer_inquiry.view')->middleware('hasPermission:customer_inquiry_read');
        Route::delete('admin/customer-inquiry/delete/{id}',    [CustomerInquiryController::class, 'delete'])->name('customer_inquiry.delete')->middleware('hasPermission:customer_inquiry_delete');
        Route::post('customer-inquiry/store',                  [CustomerInquiryController::class, 'store'])->name('customer_inquiry.store');
    });
});

// In routes/web.php
Route::post('/update-theme', function (Illuminate\Http\Request $request) {
    $theme = $request->input('theme');
    session(['theme' => $theme]);

    return response()->json(['success' => true]);
});

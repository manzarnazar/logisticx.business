<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Setting\SmsSendSettingsController;
use App\Http\Controllers\Backend\Setting\SmsSettingsController;
use App\Http\Controllers\Backend\Setting\SocialLoginController;
use App\Http\Controllers\Backend\Setting\PayoutSetupController;
use App\Http\Controllers\Backend\Setting\PickupSlotController;
use App\Http\Controllers\Backend\Setting\SettingsController;

Route::group(['middleware' => ['auth', 'XSS']], function () {

    // General settings
    Route::get('admin/settings/general-settings',              [SettingsController::class, 'generalSettings'])->name('settings.general.index')->middleware('hasPermission:general_settings_read');
    Route::put('admin/settings/update-settings',               [SettingsController::class, 'updateSettings'])->name('settings.update')->middleware('hasPermission:general_settings_update');

    Route::get('admin/settings/recaptcha/',                          [SettingsController::class, 'recaptcha'])->name('settings.recaptcha')->middleware('hasPermission:recaptcha_settings_read');


    // Mail Setting Routes
    Route::get('admin/settings/mail/index',                    [SettingsController::class, 'mailSettings'])->name('settings.mail.index')->middleware('hasPermission:mail_settings_read');
    Route::post('admin/settings/mail/test-send-mail',          [SettingsController::class, 'testSendMail'])->name('settings.testSendMail')->middleware('hasPermission:mail_settings_update');

    // database backup
    Route::get('admin/settings/database/backup',               [SettingsController::class, 'databaseBackupIndex'])->name('database.backup.index')->middleware('hasPermission:database_backup_read');
    Route::get('admin/settings/database/backup/download',      [SettingsController::class, 'databaseBackupDownload'])->name('database.backup.download')->middleware('hasPermission:database_backup_read');

    // SMS
    Route::get('admin/settings/sms/index',            [SmsSettingsController::class, 'index'])->name('sms-settings.index')->middleware('hasPermission:sms_settings_read');
    Route::get('admin/settings/sms/index/create',           [SmsSettingsController::class, 'create'])->name('sms-settings.create')->middleware('hasPermission:sms_settings_create');
    Route::post('admin/settings/sms/store',           [SmsSettingsController::class, 'store'])->name('sms-settings.store')->middleware('hasPermission:sms_settings_create');
    Route::get('admin/settings/sms/index/edit/{id}',        [SmsSettingsController::class, 'edit'])->name('sms-settings.edit')->middleware('hasPermission:sms_settings_update');
    Route::put('admin/settings/sms/update/{id}',      [SmsSettingsController::class, 'update'])->name('sms-settings.update')->middleware('hasPermission:sms_settings_update');
    Route::delete('admin/settings/sms/delete/{id}',   [SmsSettingsController::class, 'delete'])->name('sms-settings.delete')->middleware('hasPermission:sms_settings_delete');
    Route::post('admin/settings/sms/status',          [SmsSettingsController::class, 'status'])->name('sms-settings.status')->middleware('hasPermission:sms_settings_status_change');
    Route::get('admin/settings/sms-send/index',       [SmsSendSettingsController::class, 'index'])->name('sms-send-settings.index')->middleware('hasPermission:sms_send_settings_read');
    Route::post('admin/settings/sms-send/status',     [SmsSendSettingsController::class, 'status'])->name('sms-send-settings.status')->middleware('hasPermission:sms_send_settings_status_change');



    //social login settings
    Route::get('admin/settings/social-login',                          [SocialLoginController::class, 'socialLoginSettingsIndex'])->name('social.login.settings.index')->middleware('hasPermission:social_login_settings_read');
    Route::put('admin/settings/social-login/update/{social}',          [SocialLoginController::class, 'socialLoginSettingsUpdate'])->name('social.login.settings.update')->middleware('hasPermission:social_login_settings_update');



    //payout setup settings

    Route::get('admin/settings/pay-out/setup',                         [PayoutSetupController::class, 'index'])->name('settings.paymentGateway')->middleware('hasPermission:payment_gateway_settings_read');
    Route::put('admin/settings/pay-out/setup/update/{paymentmethod}',  [PayoutSetupController::class, 'PayoutSetupUpdate'])->name('payout.setup.settings.update')->middleware('hasPermission:payout_setup_settings_update');



    // pickup-slot Routes
    Route::get('admin/settings/pickup-slot/index',          [PickupSlotController::class, 'index'])->name('pickup.index')->middleware('hasPermission:pickup_read');
    Route::get('admin/settings/pickup-slot/index/create',         [PickupSlotController::class, 'create'])->name('pickup.create')->middleware('hasPermission:pickup_create');
    Route::post('admin/settings/pickup-slot/store',         [PickupSlotController::class, 'store'])->name('pickup.store')->middleware('hasPermission:pickup_create');
    Route::get('admin/settings/pickup-slot/index/edit/{id}',      [PickupSlotController::class, 'edit'])->name('pickup.edit')->middleware('hasPermission:pickup_update');
    Route::put('admin/settings/pickup-slot/update',         [PickupSlotController::class, 'update'])->name('pickup.update')->middleware('hasPermission:pickup_update');
    Route::delete('admin/settings/pickup-slot/delete/{id}', [PickupSlotController::class, 'delete'])->name('pickup.delete')->middleware('hasPermission:pickup_delete');
});

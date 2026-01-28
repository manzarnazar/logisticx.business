<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\Backend\Setting;
use App\Repositories\Upload\UploadInterface;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    private $uploadRepo;

    public function __construct(UploadInterface $uploadRepo)
    {
        $this->uploadRepo = $uploadRepo;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // General Settings
        Setting::create(['key' => 'name',                   'value' => 'Parcel Fly']);
        Setting::create(['key' => 'phone',                  'value' => '+8801811843300']);
        Setting::create(['key' => 'email',                  'value' => 'info@parcelfly.com']);
        Setting::create(['key' => 'address',                'value' => 'Address:4th floor, Feni Center, Feni-3900, Bangladesh']);
        Setting::create(['key' => 'open_hours',             'value' => 'saturday -thursday 10am-6pm']);
        Setting::create(['key' => 'official_message',       'value' => ' We are always here to help you. Feel free to reach out for any inquiries, support, or partnership opportunities.']);
        Setting::create(['key' => 'default_language',       'value' => "en"]);
        Setting::create(['key' => 'currency',               'value' => "৳"]);
        Setting::create(['key' => 'par_track_prefix',       'value' => 'We']);
        Setting::create(['key' => 'copyright',              'value' => "Copyright @ 2025 Parcel Fly Courier. Made with ❤️ by BugBuild Labs Team."]);

        Setting::create(['key' => 'light_logo',             'value' => $this->uploadRepo->uploadSeederByPath("uploads/seeders/light_logo.png")]);
        Setting::create(['key' => 'dark_logo',              'value' => $this->uploadRepo->uploadSeederByPath("uploads/seeders/dark_logo.png")]);

        Setting::create(['key' => 'favicon',                'value' => $this->uploadRepo->uploadSeederByPath("uploads/seeders/favicon.png")]);

        Setting::create(['key' => 'app_light_logo',             'value' => $this->uploadRepo->uploadSeederByPath("uploads/seeders/app_light_logo.png")]);
        Setting::create(['key' => 'app_dark_logo',              'value' => $this->uploadRepo->uploadSeederByPath("uploads/seeders/app_dark_logo.png")]);

        // 📱 App Version Control (NEW)
        // ==============================
        Setting::create(['key' => 'latest_app_version',     'value' => '1.6.0']);
        Setting::create(['key' => 'android_download_url',   'value' => 'https://play.google.com/store/apps/details?id=com.bugbuild.parcelfly']);
        Setting::create(['key' => 'ios_download_url',       'value' => 'https://apps.apple.com/app/id123456789']);

        // ==============================

        //mail settings
        Setting::create(['key' => 'sendmail_path',          'value' => '/usr/sbin/sendmail -bs -i']);
        Setting::create(['key' => 'mail_driver',            'value' => env('MAIL_MAILER', 'smtp')]);
        Setting::create(['key' => 'mail_host',              'value' => env('MAIL_HOST', 'smtp.titan.email')]);
        Setting::create(['key' => 'mail_port',              'value' => env('MAIL_PORT', 465)]);
        Setting::create(['key' => 'mail_username',          'value' => env('MAIL_USERNAME', 'admin@bugbuild.com')]);
        Setting::create(['key' => 'mail_password',          'value' => encrypt(env('MAIL_PASSWORD', '123'))]);
        Setting::create(['key' => 'mail_encryption',        'value' => env('MAIL_ENCRYPTION', 'tls')]);
        Setting::create(['key' => 'mail_address',           'value' => env('MAIL_FROM_ADDRESS', 'admin@bugbuild.com')]);
        Setting::create(['key' => 'mail_name',              'value' => env('MAIL_FROM_NAME', 'BugBuild')]);
        Setting::create(['key' => 'signature',              'value' => '<span>with regards,</span><br><br><h6>BugBuild lab</h6><small>support@bugbuild.com</small>']);


        //social login settings
        //facebook
        Setting::create(['key' => 'facebook_client_id',     'value' => '']);
        Setting::create(['key' => 'facebook_client_secret', 'value' => '']);
        Setting::create(['key' => 'facebook_status',        'value' => Status::INACTIVE]);
        
        //google
        Setting::create(['key' => 'google_client_id',       'value' => '']);
        Setting::create(['key' => 'google_client_secret',   'value' => '']);
        Setting::create(['key' => 'google_status',          'value' => Status::ACTIVE]);

        //reCaptcha settings
        Setting::create(['key' => 'recaptcha_site_key',     'value' => env('RECAPTCHA_SITE_KEY', 'fghfghfdghfghfd')]);
        Setting::create(['key' => 'recaptcha_secret_key',   'value' => env('RECAPTCHA_SECRET_KEY', 'dfgdfgghdfgdfhY9')]);
        Setting::create(['key' => 'recaptcha_status',       'value' => Status::INACTIVE]);

        // cod and fragile_liquid
        Setting::create(['key' => 'fragile_liquid_status',  'value' => Status::ACTIVE]);
        Setting::create(['key' => 'cod_inside_city',        'value' => 1]);
        Setting::create(['key' => 'cod_sub_city',           'value' => 1.7]);
        Setting::create(['key' => 'cod_outside_city',       'value' => 2]);
        Setting::create(['key' => 'liquid_fragile',         'value' => 1.8]);
        Setting::create(['key' => 'merchant_vat',           'value' => 10]);

        Setting::create(['key' => 'send_parcel_create_sms',                 'value' => Status::ACTIVE]);
        Setting::create(['key' => 'send_delivered_cancel_customer_sms',     'value' => Status::ACTIVE]);
        Setting::create(['key' => 'send_delivered_cancel_merchant_sms',     'value' => Status::ACTIVE]);

        Setting::create(['key' => 'paginate_value',     'value' => 15]);
        Setting::create(['key' => 'date_format',        'value' => 'M j, Y']);
        Setting::create(['key' => 'time_format',        'value' => 'g:i a']);
    }
}

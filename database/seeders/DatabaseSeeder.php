<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Modules\Blog\Database\Seeders\BlogSeeder;
use Modules\Faq\Database\Seeders\FaqTableSeeder;
use Modules\Team\Database\Seeders\TeamTableSeeder;
use Modules\Pages\Database\Seeders\PagesTableSeeder;
use Modules\Language\Database\Seeders\FlagIconSeeder;
use Modules\Language\Database\Seeders\LanguageSeeder;
use Modules\Client\Database\Seeders\ClientTableSeeder;
use Modules\Leave\Database\Seeders\LeaveTypeTableSeeder;
use Modules\Section\Database\Seeders\SectionTableSeeder;
use Modules\Service\Database\Seeders\ServiceTableSeeder;
use Modules\Widgets\Database\Seeders\WidgetsTableSeeder;
use Modules\HR\Database\Seeders\HolidaySeederTableSeeder;
use Modules\HR\Database\Seeders\WeekendSeederTableSeeder;
use Modules\Features\Database\Seeders\FeaturesTableSeeder;
use Modules\Leave\Database\Seeders\LeaveAssignTableSeeder;
use Modules\Gallery\Database\Seeders\GalleryDatabaseSeeder;
use Modules\Leave\Database\Seeders\LeaveRequestTableSeeder;
use Modules\Attendance\Database\Seeders\AttendanceTableSeeder;
use Modules\Testimonial\Database\Seeders\TestimonialTableSeeder;
use Modules\SocialLink\Database\Seeders\SocialLinkDatabaseSeeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        Cache::forget('settings');
        Session::forget('sections');
        Cache::forget('sections');
        Artisan::call('optimize:clear');


        $this->call(RouteListSeeder::class);

        $this->call(CurrencySeeder::class);

        // coverage seeder
        $this->call(CoverageSeeder::class);
        $this->call(LanguageSeeder::class);
        $this->call(FlagIconSeeder::class);

        // charges
        $this->call(ProductCategorySeeder::class);
        $this->call(ServiceTypeSeeder::class);
        $this->call(ServiceFaqSeeder::class);
        $this->call(HomePageSliderSeeder::class);
        $this->call(ValueAddedServiceSeeder::class);

        $this->call(ChargeSeeder::class);
        if (config('app.app_demo')) :
        endif;

        $this->call(UploadSeeder::class);

        if (config('app.app_demo')) :
            $this->call(HubSeeder::class);
        endif;

        $this->call(DepartmentSeeder::class);
        $this->call(DesignationSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(BankSeeder::class);
        $this->call(PickupSlotSeeder::class);

        if (config('app.app_demo')) :

            $this->call(DeliveryManSeeder::class);
            $this->call(HubInChargeSeeder::class);

            $this->call(MerchantSeeder::class);
            $this->call(MerchantChargeSeeder::class);
            $this->call(MerchantshopsSeeder::class);

            // $this->call(MerchantPaymentSeeder::class);
            $this->call(AccountSeeder::class);
            // $this->call(MerchantManagePaymentSeeder::class);
            $this->call(FundTransferSeeder::class);
            $this->call(PaymentAccountSeeder::class);

            $this->call(ParcelSeeder::class);
            $this->call(EventSeeder::class);
            $this->call(PaymentRequestSeeder::class);
            

        endif;

        $this->call(AccountHeadSeeder::class);
        // $this->call(ExpenseSeeder::class);

        $this->call(PermissionSeeder::class);
        // $this->call(IncomeSeeder::class);
        $this->call(SmsSettingsSeeder::class);
        $this->call(SmsSendSettingsSeeder::class);
        $this->call(SalaryGenerateSeeder::class);
        $this->call(SettingSeeder::class);

        if (config('app.app_demo')) :
            $this->call(MerchantSettingSeeder::class);
            $this->call(CouponSeeder::class);
            $this->call(PushNotificationSeeder::class);
            $this->call(To_DoSeeder::class);
            $this->call(ContactUsSeeder::class);
            $this->call(BlogSeeder::class);
            $this->call(ClientTableSeeder::class);
            $this->call(FaqTableSeeder::class);
        endif;

        // module seeder
        $this->call(FeaturesTableSeeder::class);
        $this->call(PagesTableSeeder::class);
        $this->call(SectionTableSeeder::class);

        
        if (config('app.app_demo')) :
            $this->call(ServiceTableSeeder::class);
            $this->call(GalleryDatabaseSeeder::class);
            $this->call(TeamTableSeeder::class);
            $this->call(TestimonialTableSeeder::class);
        endif;
        $this->call(WidgetsTableSeeder::class);
        if (config('app.app_demo')) :
            $this->call(SocialLinkDatabaseSeeder::class);
            $this->call(LeaveTypeTableSeeder::class);
            $this->call(LeaveAssignTableSeeder::class);
            $this->call(LeaveRequestTableSeeder::class);
            $this->call(AttendanceTableSeeder::class);
            $this->call(WeekendSeederTableSeeder::class);
            $this->call(HolidaySeederTableSeeder::class);
            $this->call(AppSliderSeeder::class);
            $this->call(SupportsTableSeeder::class);
            $this->call(CustomerInquirySeeder::class);
            $this->call(PickupRequestSeeder::class);
        endif;

        Artisan::call('optimize:clear');

    $paths = [
        storage_path('framework/cache'),
        storage_path('framework/sessions'),
        storage_path('framework/views'),
        base_path('bootstrap/cache'),
        storage_path('debugbar'),
    ];

    foreach ($paths as $path) {
        if (File::exists($path)) {
            // Delete subfolders
            foreach (File::directories($path) as $dir) {
                File::deleteDirectory($dir);
            }

            // Delete files except .gitignore
            foreach (File::files($path) as $file) {
                if ($file->getFilename() !== '.gitignore') {
                    File::delete($file->getRealPath());
                }
            }
        }
    }

    // 🔒 Fix ownership and permissions automatically (for Linux)
    try {
        exec('sudo chown -R $USER:www-data ' . escapeshellarg(storage_path()));
        exec('sudo chown -R $USER:www-data ' . escapeshellarg(base_path('bootstrap/cache')));
        exec('sudo chmod -R 775 ' . escapeshellarg(storage_path()));
        exec('sudo chmod -R 775 ' . escapeshellarg(base_path('bootstrap/cache')));
    } catch (\Throwable $e) {
        $this->command->warn('⚠️ Could not reset permissions automatically: ' . $e->getMessage());
    }

        
    }
}

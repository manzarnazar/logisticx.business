<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Auth\AuthInterface;
use App\Repositories\Bank\BankInterface;
use App\Repositories\Role\RoleInterface;
use App\Repositories\Todo\TodoInterface;
use App\Repositories\User\UserInterface;
use App\Repositories\Auth\AuthRepository;
use App\Repositories\Bank\BankRepository;
use App\Repositories\Role\RoleRepository;
use App\Repositories\Todo\TodoRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\Backup\BackupInterface;
use App\Repositories\Charge\ChargeInterface;
use App\Repositories\Coupon\CouponInterface;
use App\Repositories\Upload\UploadInterface;
use App\Repositories\Backup\BackupRepository;
use App\Repositories\Charge\ChargeRepository;
use App\Repositories\Coupon\CouponRepository;
use App\Repositories\Upload\UploadRepository;
use App\Repositories\HeroApp\HeroAppInterface;
use App\Repositories\Profile\ProfileInterface;
use App\Repositories\HeroApp\HeroAppRepository;
use App\Repositories\Profile\ProfileRepository;
use App\Repositories\Coverage\CoverageInterface;
use App\Repositories\Language\LanguageInterface;
use App\Repositories\Settings\SettingsInterface;
use App\Repositories\Coverage\CoverageRepository;
use App\Repositories\Language\LanguageRepository;
use App\Repositories\Settings\SettingsRepository;
use App\Repositories\AppSlider\AppSliderInterface;
use App\Repositories\ContactUs\ContactUsInterface;
use Modules\Gallery\Repositories\GalleryInterface;
use App\Repositories\AppSlider\AppSliderRepository;
use App\Repositories\ContactUs\ContactUsRepository;
use Modules\Gallery\Repositories\GalleryRepository;
use App\Repositories\Account\Income\IncomeInterface;
use App\Repositories\Department\DepartmentInterface;
use App\Repositories\PickupSlot\PickupSlotInterface;
use App\Repositories\ServiceFaq\ServiceFaqInterface;
use App\Repositories\ValueAddedService\VASInterface;
use App\Repositories\Account\Income\IncomeRepository;
use App\Repositories\Department\DepartmentRepository;
use App\Repositories\PickupSlot\PickupSlotRepository;
use App\Repositories\ServiceFaq\ServiceFaqRepository;
use App\Repositories\ValueAddedService\VASRepository;
use App\Repositories\Account\Account\AccountInterface;
use App\Repositories\Account\Expense\ExpenseInterface;
use App\Repositories\Designation\DesignationInterface;
use App\Repositories\ServiceType\ServiceTypeInterface;
use App\Repositories\Account\Account\AccountRepository;
use App\Repositories\Account\Expense\ExpenseRepository;
use App\Repositories\Designation\DesignationRepository;
use App\Repositories\ServiceType\ServiceTypeRepository;
use App\Repositories\LoginActivity\LoginActivityInterface;
use App\Repositories\LoginActivity\LoginActivityRepository;
use App\Repositories\HomePageSlider\HomePageSliderInterface;
use Modules\DeliveryArea\Repositories\DeliveryAreaInterface;
use App\Repositories\HomePageSlider\HomePageSliderRepository;
use Modules\DeliveryArea\Repositories\DeliveryAreaRepository;
use App\Repositories\Account\AccountHead\AccountHeadInterface;
use App\Repositories\CustomerInquiry\CustomerInquiryInterface;
use App\Repositories\ProductCategory\ProductCategoryInterface;
use App\Repositories\Account\AccountHead\AccountHeadRepository;
use App\Repositories\CustomerInquiry\CustomerInquiryRepository;
use App\Repositories\ProductCategory\ProductCategoryRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->bind(ExampleInterface::class,ExampleRepository::class);
        $this->app->bind(ProfileInterface::class,             ProfileRepository::class);
        $this->app->bind(UploadInterface::class,              UploadRepository::class);
        $this->app->bind(RoleInterface::class,                RoleRepository::class);
        $this->app->bind(UserInterface::class,                UserRepository::class);
        $this->app->bind(DesignationInterface::class,         DesignationRepository::class);
        $this->app->bind(DepartmentInterface::class,          DepartmentRepository::class);

        // $this->app->bind(LoginActivityInterface::class,       LoginActivityRepository::class);
        // $this->app->bind(LanguageInterface::class,            LanguageRepository::class);
        // $this->app->bind(AccountHeadInterface::class,         AccountHeadRepository::class);
        // $this->app->bind(AccountInterface::class,             AccountRepository::class);
        // $this->app->bind(IncomeInterface::class,              IncomeRepository::class);
        // $this->app->bind(ExpenseInterface::class,             ExpenseRepository::class);
        // $this->app->bind(BackupInterface::class,              BackupRepository::class);

        $this->app->bind(TodoInterface::class,                TodoRepository::class);
        $this->app->bind(BankInterface::class,                BankRepository::class);
        $this->app->bind(AuthInterface::class,                AuthRepository::class);
        $this->app->bind(SettingsInterface::class,          SettingsRepository::class);
        $this->app->bind(PickupSlotInterface::class,        PickupSlotRepository::class);
        $this->app->bind(CoverageInterface::class,          CoverageRepository::class);

        // Charges
        $this->app->bind(ProductCategoryInterface::class,   ProductCategoryRepository::class);
        $this->app->bind(ServiceTypeInterface::class,       ServiceTypeRepository::class);
        $this->app->bind(ServiceFaqInterface::class,       ServiceFaqRepository::class);
        $this->app->bind(HomePageSliderInterface::class,       HomePageSliderRepository::class);
        $this->app->bind(VASInterface::class,               VASRepository::class);
        $this->app->bind(ChargeInterface::class,            ChargeRepository::class);
        // End Charges

        $this->app->bind(ContactUsInterface::class,         ContactUsRepository::class);
        $this->app->bind(CouponInterface::class,            CouponRepository::class);
        $this->app->bind(AuthInterface::class,              AuthRepository::class);

        $this->app->bind(HeroAppInterface::class,           HeroAppRepository::class);
        $this->app->bind(AppSliderInterface::class,         AppSliderRepository::class);


        $this->app->bind(GalleryInterface::class,           GalleryRepository::class);
        $this->app->bind(DeliveryAreaInterface::class,      DeliveryAreaRepository::class);

        $this->app->bind(CustomerInquiryInterface::class,      CustomerInquiryRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

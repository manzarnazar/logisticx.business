<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Backend\Merchant;
use App\Models\User;
use App\Enums\Status;
use App\Enums\UserType;
use App\Models\Backend\Charges\Charge;
use App\Models\Backend\MerchantCharge;
use App\Models\Backend\Role;
use App\Models\MerchantPayment;
use App\Repositories\Upload\UploadInterface;
use Database\Factories\MerchantFactory;

class MerchantSeeder extends Seeder
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
        // MerchantFactory::times(5)->create(); // valid

        $user                           = new User();
        $user->name                     = "Merchant";
        $user->mobile                   = "8801912938003";
        $user->email                    = "merchant@bugbuild.com";
        $user->address                  = "User Test Address, Example -1201";
        $user->password                 = Hash::make('12345678');
        $user->user_type                = UserType::MERCHANT;
        $user->hub_id                   = 1;
        $user->image_id                 = $this->uploadRepo->uploadSeederByPath("uploads/seeders/user/user.png");
        $user->joining_date             = date('Y-m-d');
        $user->nid_number               = 1234567890;
        $user->email_verified_at        = now();

        $user->role_id                  = 4;
        $role                           = Role::where('slug', 'merchant')->first();
        if ($role && $role->permissions != null) {
            $user->role_id              = $role->id;
            $user->permissions          = $role->permissions;
        }

        $user->save();

        $merchant                       = new Merchant();
        $merchant->user_id              = $user->id;
        $merchant->business_name        = "Business Name Parcel Fly";
        $merchant->merchant_unique_id   = 1010101;
        $merchant->nid_id               = 4;
        $merchant->trade_license        = 5;
        $merchant->address              = "Merchant Address, Test Address";
        $merchant->coverage_id          = 1;
        $merchant->pickup_slot_id       = 1;
        $merchant->save();

        $paymentAccount                 = new MerchantPayment();
        $paymentAccount->merchant_id    = $merchant->id;
        $paymentAccount->payment_method = config('merchantpayment.payment_method.cash');
        $paymentAccount->save();
    }
}

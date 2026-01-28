<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\Status;
use App\Enums\UserType;
use App\Models\Backend\Role;
use Illuminate\Database\Seeder;
use App\Models\Backend\Department;
use App\Models\Backend\DeliveryMan;
use App\Models\Backend\Designation;
use Illuminate\Support\Facades\Hash;
use Database\Factories\DeliveryManFactory;
use App\Repositories\Upload\UploadInterface;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DeliveryManSeeder extends Seeder
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
        $designation =  Designation::firstOrCreate(['title' => "Delivery Associate"]);  // Ensure "Delivery Associate" only gets created if it doesn't exist
        $department  = Department::firstOrCreate(['title' => 'Logistics Department']);   // Ensure the department exists, create it if necessary

        $user                           = new User();
        $user->name                     = "Delivery Man";
        $user->mobile                   = "01912938004";
        $user->email                    = "deliveryman@bugbuild.com";
        $user->address                  = "Mirpur-2,Dhaka";
        $user->hub_id                   = 1;
        $user->password                 = Hash::make('12345678');

        $role                           = Role::where('slug', 'delivery-man')->first();
        if ($role && $role->permissions != null) {
            $user->role_id              = $role->id;
            $user->permissions          = $role->permissions;
        }

        $user->user_type                = UserType::DELIVERYMAN;
        // $user->salary                   = 7000;
        $user->image_id                 = $this->uploadRepo->uploadSeederByPath("uploads/seeders/user/hero-1.jpg");
        $user->joining_date             = now()->subMonths(rand(1, 30))->subDays(rand(1, 30))->format('Y-m-d');

        $user->designation_id           = $designation->id;
        $user->department_id            = $department->id;

        $user->save();

        $deliveryMan                    = new DeliveryMan();
        $deliveryMan->user_id           = $user->id;
        $deliveryMan->coverage_id       = 1;
        $deliveryMan->pickup_slot_id    = 1;
        // $deliveryMan->driving_license   = 1;
        $deliveryMan->status            = Status::ACTIVE;
        $deliveryMan->save();


        if (config('app.app_demo')) {
            DeliveryManFactory::times(5)->create();
        }
    }
}

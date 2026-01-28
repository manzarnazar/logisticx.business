<?php

namespace Database\Factories;

use App\Models\User;
use App\Enums\Status;
use App\Enums\UserType;
use App\Models\Backend\Hub;
use App\Models\Backend\Role;
use App\Models\Backend\Upload;
use App\Models\Backend\Coverage;
use App\Models\Backend\Department;
use App\Models\Backend\DeliveryMan;
use App\Models\Backend\Designation;
use Illuminate\Support\Facades\Hash;
use App\Models\Backend\Setting\PickupSlot;
use App\Repositories\Upload\UploadRepository;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class DeliveryManFactory extends Factory
{
    protected $model = DeliveryMan::class;

    public function definition()
    {
        $role           = Role::where('slug', 'delivery-man')->first();
        $hubIds         = Hub::where('status', Status::ACTIVE)->pluck('id');
        $coverageIds    = Coverage::where('status', Status::ACTIVE)->pluck('id');
        $pickupSlotIds  = PickupSlot::where('status', Status::ACTIVE)->pluck('id');

        $designation    = Designation::firstOrCreate(['title' => "Delivery Associate"]);  // Ensure "Delivery Associate" only gets created if it doesn't exist
        $department     = Department::firstOrCreate(['title' => 'Logistics Department']);   // Ensure the department exists, create it if necessary

        $UploadRepository = new UploadRepository();

        $user = User::factory()->create([
            'name'          => $this->faker->unique()->name,
            'mobile'        => $this->faker->unique()->phoneNumber,
            'email'         => 'hero.' . $this->faker->unique()->safeEmail,
            'address'       => fake()->address,
            'hub_id'        => $hubIds->random(),
            'password'      => Hash::make('12345678'),
            'role_id'       => $role->id ?? null,
            'permissions'   => $role->permissions ?? [],
            'user_type'     => UserType::DELIVERYMAN,
            // 'salary'        => rand(10000, 15000),
            'image_id'      => $UploadRepository->uploadSeederByPath("uploads/seeders/user/hero-1.jpg"),
            'nid_number'    => rand(1111111111, 9999999999),
            'joining_date'  => now()->subMonths(rand(1, 30))->subDays(rand(1, 30))->format('Y-m-d'),
            'designation_id' => $designation->id,  // Assign the "Delivery Associate" designation
            'department_id' => $department->id,   // Assign the "Logistics Department"
        ]);

        return [
            'user_id'           => $user->id,
            'coverage_id'       => $coverageIds->random(),
            'pickup_slot_id'    => $pickupSlotIds->random(),
            'status'            => Status::ACTIVE,
        ];
    }
}

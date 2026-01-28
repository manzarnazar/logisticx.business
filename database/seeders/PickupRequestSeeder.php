<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PickupRequest;
use App\Enums\PickupRequestType;

class PickupRequestSeeder extends Seeder
{
    public function run(): void
    {
        // Create 10 Regular Pickup Requests
        for ($i = 1; $i <= 10; $i++) {
            PickupRequest::create([
                'request_type'    => PickupRequestType::REGULAR,
                'merchant_id'     => 1,
                'address'         => "Regular Street #{$i}, Dhaka",
                'note'            => "Regular pickup request sample {$i}",
                'parcel_quantity' => rand(1, 50),
            ]);
        }

        // Create 10 Express Pickup Requests
        for ($i = 1; $i <= 10; $i++) {
            PickupRequest::create([
                'request_type'    => PickupRequestType::EXPRESS,
                'merchant_id'     => 1,
                'address'         => "Express Road #{$i}, Dhaka",
                'note'            => "Express pickup request sample {$i}",
                'name'            => "Customer {$i}",
                'phone'           => "+88017" . rand(10000000, 99999999),
                'cod_amount'      => rand(100, 5000),
                'invoice'         => "INV-" . (1000 + $i),
                'weight'          => rand(1, 10),
                'exchange'        => rand(0, 1),
            ]);
        }
    }
}

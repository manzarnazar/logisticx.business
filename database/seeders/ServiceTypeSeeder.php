<?php

namespace Database\Seeders;

use App\Models\Backend\Charges\ServiceType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $serviceTypes = [
            "Express Delivery",
            "Same-Day Delivery",
            "Next-Day Delivery",
            "Standard Delivery",
        ];

        $serviceTypes = collect($serviceTypes);
        $serviceTypes->each(fn ($serviceType) => 

        ServiceType::create(['name' => $serviceType, 'position' => rand(1, 10)]));
    }
}

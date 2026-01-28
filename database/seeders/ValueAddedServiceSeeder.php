<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Enums\Status;
use App\Models\Backend\Charges\ValueAddedService;
use Illuminate\Support\Facades\File;

class ValueAddedServiceSeeder extends Seeder
{
    public function run()
    {
        $valueAddedServices = collect($this->vas());

        $valueAddedServices->each(fn ($vas) => ValueAddedService::create($vas));
    }

    private function vas(): array
    {
        return [
            [
                "name" => "Premium Packaging",
                "price" => 49.99,
                "position" => 1,
                "status" => Status::ACTIVE
            ],
            [
                "name" => "Real-Time Tracking",
                "price" => 30.50,
                "position" => 2,
                "status" => Status::ACTIVE
            ],
            [
                "name" => "Secure Delivery",
                "price" => 36,
                "position" => 3,
                "status" => Status::ACTIVE
            ],
            [
                "name" => "Contactless Delivery",
                "price" => 30,
                "position" => 4,
                "status" => Status::ACTIVE
            ],
            [
                "name" => "Delivery Insurance",
                "price" => 10,
                "position" => 5,
                "status" => Status::ACTIVE
            ],
            [
                "name" => "Example",
                "price" => 10.10,
                "position" => 6,
                "status" => Status::INACTIVE
            ]
        ];
    }
}

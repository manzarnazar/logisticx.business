<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\Backend\Setting\PickupSlot;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PickupSlotSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $pickups = collect($this->pickups());

        $pickups->each(fn ($pickup) => PickupSlot::create($pickup));
    }

    private function pickups(): array
    {
        return [
            [
                'title' => 'Morning',
                'start_time' => '08:00:00',
                'end_time' => '11:00:00',
                'position' => 1,
                'status' => Status::ACTIVE,
            ],
            [
                'title' => 'Afternoon',
                'start_time' => '14:00:00',
                'end_time' => '17:00:00',
                'position' => 2,
                'status' => Status::ACTIVE,
            ],
            [
                'title' => 'Evening',
                'start_time' => '18:00:00',
                'end_time' => '21:00:00',
                'position' => 3,
                'status' => Status::ACTIVE,
            ],
            [
                'title' => 'Late Night',
                'start_time' => '23:00:00',
                'end_time' => '02:00:00',
                'position' => 4,
                'status' => Status::INACTIVE,
            ],
            [
                'title' => '24/7 Pickup',
                'start_time' => '00:00:00',
                'end_time' => '23:59:59',
                'position' => 5,
                'status' => Status::ACTIVE,
            ],
            [
                'title' => 'Weekend',
                'start_time' => '10:00:00',
                'end_time' => '14:00:00',
                'position' => 6,
                'status' => Status::INACTIVE,
            ],
            [
                'title' => 'Holiday',
                'start_time' => '12:00:00',
                'end_time' => '16:00:00',
                'position' => 7,
                'status' => Status::ACTIVE,
            ],
        ];
    }
}

<?php

namespace Modules\HR\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\HR\Entities\Weekend;

class WeekendSeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $weekends = [
            [
                'name' => 'Saturday',
                'is_weekend' => true,
            ],
            [
                'name' => 'Sunday',
                'is_weekend' => true,
            ],
            [
                'name' => 'Monday',
                'is_weekend' => false,
            ],
            [
                'name' => 'Tuesday',
                'is_weekend' => false,
            ],
            [
                'name' => 'Wednesday',
                'is_weekend' => false,
            ],
            [
                'name' => 'Thursday',
                'is_weekend' => false,
            ],
            [
                'name' => 'Friday',
                'is_weekend' => false,
            ],
        ];

        foreach ($weekends as $weekend) {
            Weekend::create($weekend);
        }
    }
}

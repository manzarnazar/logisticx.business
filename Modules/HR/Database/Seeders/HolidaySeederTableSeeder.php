<?php

namespace Modules\HR\Database\Seeders;

use App\Enums\Status;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\HR\Entities\Holiday;

class HolidaySeederTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // Create 5 records
        for ($i = 1; $i <= 5; $i++) {
            Holiday::create([
                'title' => "Holiday $i",
                'from' => Carbon::now()->addDays($i),
                'to' => Carbon::now()->addDays($i + 2),
                'description' => "Description for Holiday $i",
                'status' => ($i % 2 == 0) ? Status::ACTIVE : Status::INACTIVE,
            ]);
        }
    }
}

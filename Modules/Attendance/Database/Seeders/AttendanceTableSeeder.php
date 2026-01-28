<?php

namespace Modules\Attendance\Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Attendance\Entities\Attendance;
use Modules\Attendance\Enums\AttendanceType;

class AttendanceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Step 1: Get user IDs of non-merchants
        $userIds = User::whereDoesntHave('merchant')->pluck('id')->toArray();

        // Step 2: Generate last 15 non-weekend dates
        $dates  = collect();
        $day    = now();

        while ($dates->count() < 15) {
            if (!$day->isWeekend()) {
                $dates->push($day->toDateString());
            }
            $day = $day->subDay();
        }

        $dates = $dates->reverse()->values()->all(); // Oldest to newest

        // Step 3: Create attendance records
        foreach ($userIds as $userId) {
            foreach ($dates as $date) {

                $checkIn = Carbon::createFromTime(fake()->numberBetween(8, 10), fake()->numberBetween(0, 59));

                $checkOut = (clone $checkIn)->addHours(fake()->numberBetween(6, 9))->addMinutes(fake()->numberBetween(0, 59));

                Attendance::create([
                    'user_id'   => $userId,
                    'date'      => $date,
                    'check_in'  => $checkIn->format('H:i:s'),
                    'check_out' => $checkOut->format('H:i:s'),
                    'type'      => AttendanceType::PRESENT,
                    'note'      => fake()->sentence(),
                ]);
            }
        }
    }
}

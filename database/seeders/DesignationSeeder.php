<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Backend\Designation;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = fake();

        // Create 10 random designations using fake()->jobTitle()
        collect(range(1, 10))->each(fn() => Designation::create(['title' => $faker->jobTitle()]));
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class CustomerInquirySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $subjects = ['Shipping inquiry', 'Delivery time', 'Pricing question', 'Return policy', 'Payment methods'];

        $data = [];

        for ($i = 0; $i < 20; $i++) {
            $data[] = [
                'name' => $faker->name,
                'phone' => $faker->phoneNumber,
                'email' => $faker->unique()->safeEmail,
                'subject' => $faker->randomElement($subjects),
                'message' => $faker->paragraph,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('customer_inquiries')->insert($data);
    }
}

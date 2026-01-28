<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use App\Models\ContactUs;
use Illuminate\Database\Seeder;
// use Illuminate\Database\Eloquent\Factories\Factory;

class ContactUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactUs::factory()->count(5)->create();

        // Seed custom messages using Faker
        $faker              = Faker::create();

        $messages           = collect(range(1, 2))->map(function ($i) use ($faker) {
            return [
                'name'      => $faker->name,
                'email'     => $faker->unique()->safeEmail,
                'phone'     => $faker->phoneNumber,
                'address'   => $faker->address,
                'message'   => "Test message {$i}: " . $faker->paragraph,
            ];
        });

        $messages->each(fn ($message) => ContactUs::create($message));

    }
}

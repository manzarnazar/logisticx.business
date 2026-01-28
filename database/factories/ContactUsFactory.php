<?php

namespace Database\Factories;

use App\Models\ContactUs;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContactUs>
 */
class ContactUsFactory extends Factory
{
    protected $model = ContactUs::class; // need if the naming convention of factory class is different

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'      => $this->faker->unique()->name,
            'email'     => $this->faker->unique()->safeEmail,
            'message'   => $this->faker->unique()->realText,
        ];
    }
}

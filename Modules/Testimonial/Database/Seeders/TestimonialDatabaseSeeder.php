<?php

namespace Modules\Testimonial\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Testimonial\Database\Seeders\TestimonialTableSeeder;

class TestimonialDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
        $this->call(TestimonialTableSeeder::class);
    }
}

<?php

namespace Modules\Testimonial\Database\Seeders;

use Faker\Factory;
use App\Models\Backend\Upload;
use App\Repositories\Upload\UploadInterface;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Testimonial\Entities\Testimonial;

class TestimonialTableSeeder extends Seeder
{
    private $uploadRepo;

    public function __construct(UploadInterface $uploadRepo)
    {
        $this->uploadRepo = $uploadRepo;
    }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        for ($key = 0; $key < 10; $key++) {
            $testimonial              = new Testimonial();
            $testimonial->client_name = fake()->name();
            $testimonial->description = fake()->sentences(asText: true);
            $testimonial->designation = 'Developer';
            $testimonial->rating      = rand(0.5, 5);
            $testimonial->image       = $this->uploadRepo->uploadSeederByPath("uploads/seeders/user/user-" . rand(1, 5) . '.png');
            $testimonial->position    = $key;
            $testimonial->save();
        }
    }
}

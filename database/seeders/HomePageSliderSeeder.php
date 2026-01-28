<?php

namespace Database\Seeders;

use App\Enums\Status;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
use App\Models\Backend\Upload;
use App\Models\HomePageSlider;
use App\Repositories\Upload\UploadInterface;
use Illuminate\Database\Seeder;

class HomePageSliderSeeder extends Seeder
{
    private $uploadRepo;

    public function __construct(UploadInterface $uploadRepo)
    {
        $this->uploadRepo = $uploadRepo;
    }

    public function run()
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 5; $i++) {
            $HomePageSlider = new HomePageSlider();

            // Make each record unique
            $HomePageSlider->small_title   = $faker->catchPhrase(); // short catchy phrase
            $HomePageSlider->title         = $faker->sentence(4);   // random 4-word sentence
            $HomePageSlider->description   = $faker->unique()->sentence(12);
            $HomePageSlider->page_link     = $faker->unique()->url();
            $HomePageSlider->video_link    = "https://www.youtube.com/embed/jYUZAF3ePFE?si=Pdcan9VA_jSZQs0I";
            $HomePageSlider->position      = $i;
            $HomePageSlider->banner        = $this->uploadRepo->uploadSeederByPath(
                'uploads/seeders/front_slider/hero-' . rand(1, 5) . '.jpg'
            );
            $HomePageSlider->date          = $faker->unique()->date();
            $HomePageSlider->status        = Status::ACTIVE;

            $HomePageSlider->save();
        }
    }
}

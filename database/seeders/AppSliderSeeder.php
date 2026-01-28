<?php

namespace Database\Seeders;

use App\Enums\Status;
use Illuminate\Database\Seeder;
use App\Models\Backend\AppSlider;
use App\Repositories\Upload\UploadInterface;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AppSliderSeeder extends Seeder
{
    private $uploadRepo;

    public function __construct(UploadInterface $uploadRepo)
    {
        $this->uploadRepo = $uploadRepo;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $app_slider               = new AppSlider();
        $app_slider->title        = "Manage Your Parcel Deliveries Easily as a Merchant";
        $app_slider->image_id     = $this->uploadRepo->uploadSeederByPath("uploads/seeders/app-slider/slide-1.png");
        $app_slider->position     = 1;
        $app_slider->status       = Status::ACTIVE;
        $app_slider->description  = fake()->paragraph(1);
        $app_slider->save();

        $app_slider               = new AppSlider();
        $app_slider->title        = "Track and Control Your Merchant Parcel Orders";
        $app_slider->image_id     = $this->uploadRepo->uploadSeederByPath("uploads/seeders/app-slider/slide-2.png");
        $app_slider->position     = 2;
        $app_slider->status       = Status::ACTIVE;
        $app_slider->description  = fake()->paragraph(1);
        $app_slider->save();

        $app_slider               = new AppSlider();
        $app_slider->title        = "Grow Your Business with Seamless Parcel Delivery";
        $app_slider->image_id     = $this->uploadRepo->uploadSeederByPath("uploads/seeders/app-slider/slide-3.png");
        $app_slider->position     = 3;
        $app_slider->status       = Status::ACTIVE;
        $app_slider->description  = fake()->paragraph(1);
        $app_slider->save();
    }

}

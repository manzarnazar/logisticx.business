<?php

namespace Modules\Gallery\Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Modules\Gallery\Entities\Gallery;
use App\Repositories\Upload\UploadInterface;

class GalleryDatabaseSeeder extends Seeder
{
    private $uploadRepo;

    public function __construct(UploadInterface $uploadRepo)
    {
        $this->uploadRepo = $uploadRepo;
    }
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 1; $i < 11; $i++) {
            $gallery               = new Gallery();
            $gallery->position     = $i;
            $gallery->image_id       = $this->uploadRepo->uploadSeederByPath('uploads/seeders/section/delivery-' . rand(1, 5) . '.jpg');
            $gallery->title        = $faker->sentence;
            $gallery->short_description  = $faker->paragraphs(5, true);
            $gallery->save();
        }
    }
}

<?php

namespace Modules\Blog\Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Support\Str;

use App\Models\Backend\Upload;
use App\Repositories\Upload\UploadInterface;
use Illuminate\Database\Seeder;
use Modules\Blog\Entities\Blog;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class BlogSeeder extends Seeder
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
        $faker = Faker::create();

        for ($i = 1; $i < 101; $i++) {
            $blog               = new Blog();
            $blog->author       = 1;
            $blog->position     = $i;
            $blog->banner       = $this->uploadRepo->uploadSeederByPath('uploads/seeders/section/delivery-' . rand(1, 5) . '.jpg');
            $blog->title        = $faker->sentence;
            $blog->slug         = Str::slug($blog->title);
            $blog->date         = $faker->unique()->date();
            $blog->description  = $faker->paragraphs(15, true);
            $blog->save();
        }
    }
}

<?php

namespace Modules\Features\Database\Seeders;

use Faker\Factory as Faker;
use App\Models\Backend\Upload;
use App\Repositories\Upload\UploadInterface;
use Illuminate\Database\Seeder;
use Modules\Features\Entities\Features;
use Illuminate\Database\Eloquent\Model;


class FeaturesTableSeeder extends Seeder
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
        $features = [
            'bicycle'   => 'Bike Transport',
            'ship'      => 'Boat Service',
            'airplane'  =>  'Air Transport',
            'van'       => 'Road Transports'
        ];

        $descriptions = [
            'bicycle'   => 'Fast and eco-friendly delivery using two-wheelers for intra-city transport.',
            'ship'      => 'Reliable boat-based logistics ideal for large and international waterway shipments.',
            'airplane'  => 'Quick and efficient long-distance delivery via air cargo services.',
            'van'       => 'Flexible and secure road transport suitable for urban and suburban deliveries.'
        ];


        $position = 1;
        foreach ($features as $key => $value) {
            $feature                = new Features();
            $feature->title         = $value;
            $feature->image         = $this->uploadRepo->uploadSeederByPath('uploads/seeders/icons/icon-' . $key . '.png');
            $feature->description   = $descriptions[$key];
            $feature->position      = $position++;
            $feature->save();
        }
    }
}

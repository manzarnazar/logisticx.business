<?php

namespace Modules\Service\Database\Seeders;

use App\Models\Backend\Upload;
use App\Repositories\Upload\UploadInterface;
use Illuminate\Database\Seeder;
use Modules\Service\Entities\Service;
use Illuminate\Database\Eloquent\Model;

class ServiceTableSeeder extends Seeder
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

        $services = [
            'office'                => 'Ware House',
            'van'                   => 'Pick and Drop',
            'parcel-cod'            => 'Cash On Delivery',
            'support-female'        => 'Customer Support',
            'parcel-location-pin'   => 'Quick Transport',
            'e-commerce-delivery'   => 'E-commerce Delivery',
            'parcel-cod'            => 'Inventory Management',
            'icon-parcel'           => 'Real-time Tracking',
            'icon-home'             => 'Packaging Services',
            'e-commerce-delivery'   => 'International Shipping',
        ];

        $position = 0;
        $index = 1;

        foreach ($services as $key => $value) {
            $service                    = new Service();
            $service->title             = $value;
            $service->image             = $this->uploadRepo->uploadSeederByPath('uploads/seeders/icons/' . $key . '.png');
            $service->banner_image      = $this->uploadRepo->uploadSeederByPath('uploads/seeders/service/service-' . $index . '.jpg');
            $service->short_description = 'Complete fulfillment solutions including storing, sorting, processing. We offer the lowest price with the highest.';
            $service->position          = $position++;
            $service->save();

            $index++; // ✅ Add this line to increment index
        }
    }
}

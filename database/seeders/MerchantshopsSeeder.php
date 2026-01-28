<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\Backend\Coverage;
use App\Models\Backend\Hub;
use App\Models\Backend\Merchant;
use App\Models\MerchantShops;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MerchantshopsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $merchantIds = Merchant::pluck('id');
        $hubs        = Hub::all();


        foreach ($merchantIds as $mid) {
            $i = 1;

            foreach ($hubs as $hub) {

                $shop                   = new MerchantShops();
                $shop->merchant_id      = $mid;
                $shop->name             = "Shop {$i}";
                $shop->contact_no       = "01" . rand(993333333, 999999999);
                $shop->address          = fake()->address;
                $shop->hub_id           = $hub->id;
                $shop->coverage_id      = $hub->coverage_id;
                $shop->status           = Status::ACTIVE;
                $shop->default_shop     = $i == 1 ? Status::ACTIVE : Status::INACTIVE;
                $shop->save();

                $i++;
            }

        }
    }
}

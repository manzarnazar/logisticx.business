<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\Backend\Charges\Charge;
use App\Models\Backend\Merchant;
use App\Models\Backend\MerchantCharge;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MerchantChargeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $merchantIds = Merchant::pluck('id');

        foreach ($merchantIds as $mid) {

            $charges = Charge::where('status', Status::ACTIVE)->take(3)->orderBy('position', 'desc')->get();

            foreach ($charges as $charge) {
                $merchantCharge                         = new MerchantCharge();
                $merchantCharge->merchant_id            = $mid;
                $merchantCharge->charge_id              = $charge->id;
                $merchantCharge->product_category_id    = $charge->product_category_id;
                $merchantCharge->service_type_id        = $charge->service_type_id;
                $merchantCharge->area                   = $charge->area;
                $merchantCharge->delivery_time          = $charge->delivery_time;
                $merchantCharge->charge                 = rand(100, 150);
                $merchantCharge->additional_charge      = rand(100, 150) / 2;
                $merchantCharge->position               = $charge->position;
                $merchantCharge->status                 = $charge->status;
                $merchantCharge->save();
            }
        }
    }
}

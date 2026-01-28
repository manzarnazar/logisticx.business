<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\ServiceFaq;
use App\Models\Backend\Charges\ServiceType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceFaqSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()

    {



        $serviceFaq                        = new ServiceFaq();
        $serviceFaq->title                 = "services faq";
        $serviceFaq->position              = "1";
        $serviceFaq->service_id            = "1";
        $serviceFaq->description           = "if anyone want to know the price of fast shipping service whithin 2 hour cost will be 2000 taka";
        $serviceFaq->status                = Status::ACTIVE;

        $serviceFaq->created_at            = "2025-06-26 17:24:15";
        $serviceFaq->updated_at            = "2025-06-26 17:24:15";

        $serviceFaq->save();
    }
}

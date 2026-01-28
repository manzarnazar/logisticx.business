<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Models\Backend\Income;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IncomeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $income                        = new Income();
        $income->account_head_id       = 1;
        $income->from                  = 1;
        $income->merchant_id           = 1;

        $income->account_id            = 1;
        $income->amount                = 00;
        $income->date                  = "2022-05-17";
        $income->receipt               = null;
        $income->note                  = "Lorem ipsum dolor sit amet consectetur adipisicing elit. Nesciunt, provident!";
        $income->save();

        $parcelIds = [1, 2, 3];
        $income->parcels()->sync($parcelIds, ['created_at' => now(), 'updated_at' => now()]);
    }
}

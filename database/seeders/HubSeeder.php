<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Backend\Hub;

class HubSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hubNames = ['Mirpur-10', 'Uttara', 'Dhanmondi', 'feni', 'ctg', 'motijheel', 'gazipur', 'narayenganj'];

        $hubNames = collect($hubNames);

        $hubNames->each(function ($name) {
            $hub                  = new Hub();
            $hub->name            = $name;
            $hub->phone           = '01' . rand(333333333, 999999999);
            $hub->address         = 'Demo Address of ' . $name;
            $hub->coverage_id     = rand(1, 5);
            $hub->save();
        });
    }
}

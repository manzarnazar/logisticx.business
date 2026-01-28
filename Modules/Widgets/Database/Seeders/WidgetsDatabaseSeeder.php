<?php

namespace Modules\Widgets\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Widgets\Database\Seeders\WidgetsTableSeeder;

class WidgetsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(WidgetsTableSeeder::class);
    }
}

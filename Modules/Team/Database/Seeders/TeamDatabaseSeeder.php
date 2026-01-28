<?php

namespace Modules\Team\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Team\Database\Seeders\TeamTableSeeder;

class TeamDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");
        $this->call(TeamTableSeeder::class);
    }
}

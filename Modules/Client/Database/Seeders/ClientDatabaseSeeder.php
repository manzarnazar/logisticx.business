<?php

namespace Modules\Client\Database\Seeders;


use Faker\Factory as Faker;
use App\Models\Backend\Upload;

use Illuminate\Database\Seeder;
use Modules\Client\Entities\Client;
use Illuminate\Database\Eloquent\Model;

class ClientDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    // public function run()
    // {
    //     Model::unguard();

    //     // $this->call("OthersTableSeeder");
    // }

    public function run()
    {
        $this->call(ClientTableSeeder::class);
    }

}

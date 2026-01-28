<?php

namespace Modules\Team\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Team\Entities\Team;

class TeamTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        for ($i=1; $i < 5; $i++) { 
            $row              =  new Team();
            $row->user_id     = $i+1;
            $row->position    = $i;
            $row->facebook    = "";
            $row->twitter     = "";
            $row->linkedin    = "";
            $row->save();
        }

    }
    
}

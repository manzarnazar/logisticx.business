<?php

namespace Modules\Leave\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Leave\Entities\LeaveType;
use Illuminate\Database\Eloquent\Model;

class LeaveTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();


        LeaveType::create([
            'name' => 'Sick Leave',
            'position' => '0'
        ]);
        LeaveType::create([
            'name' => 'Paternity Leave',
            'position' => '1'
        ]);
        LeaveType::create([
            'name' => 'Annual Leave',
            'position' => '2'
        ]);
        LeaveType::create([
            'name' => 'Casual Leave',
            'position' => '3'
        ]);

        // $this->call("OthersTableSeeder");
    }
}

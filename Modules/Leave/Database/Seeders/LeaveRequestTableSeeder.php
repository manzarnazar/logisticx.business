<?php

namespace Modules\Leave\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Leave\Entities\LeaveRequest;

class LeaveRequestTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // LeaveRequest::create([
        //     'date'          =>  now(),
        //     'from_date'     =>  '12/8/10',
        //     'to_date'       =>  '14/8/10',
        //     'days'          =>  '2',
        //     'type_id'       =>  '2',
        //     'department_id' =>  '1',
        //     'role_id'       =>  '2',
        //     'user_id'       =>  '2', //admin: only can view his own leave request
        //     'reason'        =>  'Busy',
        //     'status'        =>  '2',

        // ]);
    }
}

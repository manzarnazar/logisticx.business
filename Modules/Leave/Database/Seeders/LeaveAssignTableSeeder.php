<?php

namespace Modules\Leave\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Leave\Entities\LeaveAssign;

class LeaveAssignTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        Model::unguard();


        $departments = [
            "General Manager",
            "Marketing",
            "Operations",
            "Finance",
            "Sales",
            "Human Resources",
            "Purchase"
        ];

        $leaveTypes = [
            "Sick Leave",
            "Paternity Leave",
            "Annual Leave",
            "Casual Leave"
        ];

        $days = 4;
        foreach ($departments as $dep_key => $department) {
            foreach ($leaveTypes as $req_key => $leaveType) {

                LeaveAssign::create([
                    'department_id' => $dep_key + 1,
                    'type_id' => $req_key + 1,
                    'days' => $days,
                    'position' => $dep_key
                ]);
            }
            $days += 1;
        }
    }
}

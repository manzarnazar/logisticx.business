<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Backend\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            'Sales',
            'Finance',
            'Purchase',
            'Marketing',
            'Operations',
            'Human Resource',
            'General Management',
        ];

        for ($n = 0; $n < sizeof($departments); $n++) {
            $dep        = new Department;
            $dep->title = $departments[$n];
            $dep->save();
        }
    }
}

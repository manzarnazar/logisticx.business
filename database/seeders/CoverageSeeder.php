<?php

namespace Database\Seeders;

use App\Enums\Status;
use Illuminate\Database\Seeder;
use App\Models\Backend\Coverage;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CoverageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Example: Dhaka District
        $dhaka = Coverage::create(['name' => 'Dhaka', 'parent_id' => null]);

        // Thanas under Dhaka
        $dhanmondi = Coverage::create(['name' => 'Dhanmondi', 'parent_id' => $dhaka->id]);
        $mirpur = Coverage::create(['name' => 'Mirpur', 'parent_id' => $dhaka->id]);

        // Areas under Thanas
        Coverage::insert([
            ['name' => 'Salimullah Road(M)', 'parent_id' => $dhanmondi->id],
            ['name' => 'Satmasjid Road', 'parent_id' => $dhanmondi->id],
            ['name' => 'Mirpur 10', 'parent_id' => $mirpur->id],
        ]);

        // Example: Chittagong District
        $ctg = Coverage::create(['name' => 'Chittagong', 'parent_id' => null]);

        // Thanas under Chittagong
        $pahartali = Coverage::create(['name' => 'Pahartali', 'parent_id' => $ctg->id]);

        // Areas under Pahartali
        Coverage::insert([
            ['name' => 'Agrabad', 'parent_id' => $pahartali->id],
            ['name' => 'Halishahar', 'parent_id' => $pahartali->id],
        ]);

        
        // $position = 1;

        // $areas = $this->areas();

        // foreach ($areas as $area) {

        //     $row = [
        //         "name" => $area["name"],
        //         "parent_id" => null,
        //         "position" => $position,
        //         "status" => Status::ACTIVE,
        //     ];

        //     $parent = Coverage::create($row);
        //     $position++;

        //     // Check if child areas are defined
        //     if (isset($area["child"]) && is_array($area["child"])) {

        //         foreach ($area["child"] as $child) {

        //             $row['name']        = $child["name"];
        //             $row['parent_id']   = $parent->id;
        //             $row['position']   = $position;

        //             Coverage::create($row);
        //             $position++;
        //         }
        //     }
        // }
    }

    private function areas(): array
    {
        return [
            [
                "name" => "Dhaka",
                "child" => [
                    ["name" => "Gulshan"],
                    ["name" => "Banani"],
                ],
            ],
            [
                "name" => "Chittagong",
                "child" => [
                    ["name" => "Chittagong Sadar"],
                    ["name" => "Mirsharai"],
                ],
            ],
            [
                "name" => "Feni",
                "child" => [
                    ["name" => "Feni Sadar"],
                    ["name" => "Daganbhuiyan"],
                ],
            ],
        ];
    }
}

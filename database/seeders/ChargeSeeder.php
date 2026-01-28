<?php

namespace Database\Seeders;

use App\Enums\Area;
use App\Enums\Status;
use App\Models\Backend\Charges\Charge;
use App\Models\Backend\Charges\ProductCategory;
use App\Models\Backend\Charges\ServiceType;
use Illuminate\Database\Seeder;

class ChargeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pcIDs = ProductCategory::whereIn('id', [1, 2, 3])->pluck('id')->toArray();
        $stIDs = ServiceType::whereIn('id', [1, 4])->pluck('id')->toArray();

        $areaValues = array_map(fn($a) => $a->value, Area::cases()); // ['inside_city', 'outside_city', 'sub_city']
        $areaCount = count($areaValues);

        $position = 0;
        $status   = Status::ACTIVE;

        $charges = [];
        $recordCombinations = [];

        $desiredRecord = 20;
        $areaIndex     = 0;

        foreach ($pcIDs as $pcID) {
            foreach ($stIDs as $stID) {
                foreach ($areaValues as $area) {
                    if (count($charges) >= $desiredRecord) {
                        break 3; // Exit all loops when desired record count is met
                    }

                    $combination = $pcID . $stID . $area;
                    if (in_array($combination, $recordCombinations)) {
                        $status = Status::INACTIVE;
                        continue;
                    }

                    $recordCombinations[] = $combination;
                    $position++;

                    $charges[] = [
                        "product_category_id"            => $pcID,
                        "service_type_id"                => $stID,
                        "area"                           => $area,
                        "delivery_time"                  => rand(12, 168),
                        "charge"                         => rand(40, 50),
                        "additional_charge"              => rand(30, 40),
                        "return_charge"                  => rand(80, 100),
                        "delivery_commission"           => rand(25, 30),
                        "additional_delivery_commission" => rand(15, 20),
                        "position"                       => $position,
                        "status"                         => $status,
                    ];

                    $status = Status::ACTIVE;
                }
            }
        }

        Charge::insert($charges);
    }
}

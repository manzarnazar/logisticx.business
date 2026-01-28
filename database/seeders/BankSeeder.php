<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\Backend\Bank;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->banks() as $key => $bank) {
            Bank::create(['bank_name' => $bank, 'position' => $key, 'status' => Status::ACTIVE]);
        }
    }

    private function banks(): array
    {
        return [
            'AB Bank Limited',
            'Agrani Bank Limited',
            'Bank Asia Limited',
            'BRAC Bank Limited',
            'City Bank Limited',
            'Dhaka Bank Limited',
            'Dutch-Bangla Bank Limited',
            'Eastern Bank Limited',
            'EXIM Bank Bangladesh Limited',
            'IFIC Bank Limited',
            'Islami Bank Bangladesh Limited',
            'Jamuna Bank Limited',
            'Mercantile Bank Limited',
            'Mutual Trust Bank Limited',
            'National Bank Limited',
            'NRB Bank Limited',
            'NRB Commercial Bank Limited',
            'One Bank Limited',
            'Prime Bank Limited',
            'Southeast Bank Limited',
            'Standard Bank Limited',
            'Standard Chartered Bank',
            'The Premiere Bank Limited',
            'Trust Bank Limited',
            'United Commercial Bank Limited',
            'Uttara Bank Limited',
        ];
    }
}

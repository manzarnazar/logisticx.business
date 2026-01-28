<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SupportsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = ['Technical Support', 'Customer Service', 'Product Support', 'Human Resources'];
        $priorities = ['High', 'Medium', 'Low'];
        $subjects = [
            'Server Down Issue',
            'Billing Inquiry',
            'Product Installation Guidance',
            'Network Issue',
            'Account Password Reset',
            'Feature Request',
            'Employee Benefit Inquiry',
            'Software Installation Issue'
        ];
        $descriptions = [
            'The server is down and needs immediate attention.',
            'Customer has an inquiry about their latest bill.',
            'Need help installing the new product update.',
            'There seems to be a network issue in the main office.',
            'Customer requested a password reset for their account.',
            'Customer wants to request a new feature for the product.',
            'Employee inquired about the new benefit policies.',
            'Unable to install new software update on client machines.'
        ];

        for ($i = 1; $i <= 8; $i++) {
            DB::table('supports')->insert([
                'user_id' => 9,
                'department_id' => rand(1, 4),  // Assuming you have 4 departments
                'service' => $services[array_rand($services)],
                'priority' => $priorities[array_rand($priorities)],
                'subject' => $subjects[$i - 1],
                'description' => $descriptions[$i - 1],
                'date' => Carbon::now()->format('Y-m-d'),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}

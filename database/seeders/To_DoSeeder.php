<?php

namespace Database\Seeders;

use App\Models\Backend\To_do;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class To_DoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = User::pluck('id');

        for ($i = 0; $i < 5; $i++) {
            To_do::create([
                'title' => 'Test Task ' . ($i + 1),
                'description' => 'Description for Test Task ' . ($i + 1),
                'user_id' => $userIds->random(),
                'date' => Carbon::now()->addDays($i),
                'status' => rand(1, 3),
                'note' => 'Note for Test Task ' . ($i + 1),
            ]);
        }
    }
}

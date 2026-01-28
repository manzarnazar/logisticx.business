<?php

namespace Database\Seeders;

use App\Enums\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Backend\Account;
use App\Models\Backend\Bank;
use App\Models\User;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users   = User::where('user_type', UserType::ADMIN)->orWhere('user_type', UserType::INCHARGE)->get();
        $bankIds = Bank::pluck('id');

        foreach ($users as $user) {
            $account                       = new Account();
            $account->type                 = 1;
            $account->user_id              = $user->id;
            $account->hub_id               = $user->hub_id;
            $account->gateway              = 2;
            $account->account_holder_name  = $user->name;
            $account->account_no           = rand(10000000, 99999999);
            $account->bank_id              = $bankIds->random();
            $account->branch_name          = "Dhaka";
            $account->opening_balance      = rand(100000, 200000);
            $account->balance              = $account->opening_balance;
            $account->save();
        }

    }
}

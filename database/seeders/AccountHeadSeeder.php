<?php

namespace Database\Seeders;

use App\Enums\AccountHeads;
use App\Enums\Status;
use App\Models\Backend\AccountHead;
use Illuminate\Database\Seeder;

class AccountHeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //expense
        $account_heads         = new AccountHead();
        $account_heads->type   = AccountHeads::EXPENSE;
        $account_heads->name   = 'Pay to Hub';
        $account_heads->status = Status::ACTIVE;
        $account_heads->save();

        $account_heads         = new AccountHead();
        $account_heads->type   = AccountHeads::EXPENSE;
        $account_heads->name   = 'Pay Delivery Man Commission';
        $account_heads->status = Status::ACTIVE;
        $account_heads->save();

        $account_heads         = new AccountHead();
        $account_heads->type   = AccountHeads::EXPENSE;
        $account_heads->name   = 'Paid to Merchant';
        $account_heads->status = Status::ACTIVE;
        $account_heads->save();


        //income

        $account_heads         = new AccountHead();
        $account_heads->type   = AccountHeads::INCOME;
        $account_heads->name   = 'Received from Delivery Man';
        $account_heads->status = Status::ACTIVE;
        $account_heads->save();

        $account_heads         = new AccountHead();
        $account_heads->type   = AccountHeads::INCOME;
        $account_heads->name   = 'Received from Merchant';
        $account_heads->status = Status::ACTIVE;
        $account_heads->save();

        $account_heads         = new AccountHead();
        $account_heads->type   = AccountHeads::INCOME;
        $account_heads->name   = 'Received from Hub';
        $account_heads->status = Status::ACTIVE;
        $account_heads->save();


        // others

        $account_heads         = new AccountHead();
        $account_heads->type   = AccountHeads::EXPENSE;
        $account_heads->name   = 'Paid to admin';
        $account_heads->status = Status::ACTIVE;
        $account_heads->save();

        $account_heads         = new AccountHead();
        $account_heads->type   = AccountHeads::EXPENSE;
        $account_heads->name   = 'Others Expanse';
        $account_heads->status = Status::ACTIVE;
        $account_heads->save();

        $account_heads         = new AccountHead();
        $account_heads->type   = AccountHeads::INCOME;
        $account_heads->name   = 'Others Income';
        $account_heads->status = Status::ACTIVE;
        $account_heads->save();
    }
}

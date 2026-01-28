<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\MerchantPayment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MerchantPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payment = new MerchantPayment();
        $payment->merchant_id       = 1;
        $payment->payment_method    = 'bank';
        $payment->bank_id           = 1;
        $payment->branch_name       = 'Example Branch';
        $payment->routing_no        = 123456;
        $payment->account_type      = 'current';
        $payment->account_name      = 'Example Account Name';
        $payment->account_no        = 123456;
        $payment->mobile_no         = '01300000000';
        $payment->status            = Status::ACTIVE;

        $payment->save();

        foreach (config('merchantpayment.mfs_providers') as $value) {
            $payment = new MerchantPayment();
            $payment->merchant_id      = 1;
            $payment->payment_method   = 'mfs';
            $payment->mfs              = $value;
            $payment->account_name     = 'Example Account Name';
            $payment->account_no        = '01300000000';
            $payment->mobile_no        = '01300000000';
            $payment->account_type     = 'personal';
            $payment->status           = Status::ACTIVE;
            $payment->save();
        }
    }
}

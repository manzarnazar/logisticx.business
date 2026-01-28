<?php

namespace Database\Seeders;

use App\Models\Backend\SmsSetting;
use Illuminate\Database\Seeder;

class SmsSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $smsSetting                       = new SmsSetting();
        $smsSetting->gateway              = 'REVE SMS';
        $smsSetting->api_key              = 'a7e4166cc9967d80';
        $smsSetting->secret_key           = 'e863dd2f';
        $smsSetting->username             = '';
        $smsSetting->user_password        = '';
        $smsSetting->api_url              = 'http://smpp.ajuratech.com:7788/sendtext';
        $smsSetting->status               = 1;
        $smsSetting->save();
    }
}

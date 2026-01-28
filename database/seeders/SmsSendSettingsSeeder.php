<?php

namespace Database\Seeders;

use App\Enums\Status;
use App\Models\Backend\SmsSendSetting;
use Illuminate\Database\Seeder;

class SmsSendSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (config('site.status.sms_send') as $key => $status) {
            $smsSendSetting                       = new SmsSendSetting();
            $smsSendSetting->sms_send_status      = $key;
            $smsSendSetting->status               = Status::INACTIVE;
            $smsSendSetting->save();
        }
    }
}

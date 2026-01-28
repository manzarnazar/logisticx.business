<?php

namespace App\Repositories\SocialLoginSettings;

use App\Enums\Status;
use App\Models\Backend\Setting;
use App\Traits\ReturnFormatTrait;
use App\Repositories\SocialLoginSettings\SocialLoginSettingsInterface;
use Illuminate\Support\Facades\Cache;

class SocialLoginSettingsRepository implements SocialLoginSettingsInterface
{
    use ReturnFormatTrait;

    public function update($request, $social)
    {
        try {

            if ($social == 'google') :
                $onlyInput  = [
                    'google_client_id',
                    'google_client_secret',
                    'google_status'
                ];
                $request['google_status'] = $request->google_status ? Status::ACTIVE : Status::INACTIVE;

            elseif ($social == 'facebook') :
                $onlyInput  = [
                    'facebook_client_id',
                    'facebook_client_secret',
                    'facebook_status'
                ];
                $request['facebook_status'] = $request->facebook_status ? Status::ACTIVE : Status::INACTIVE;
            endif;

            foreach ($request->only($onlyInput) as $key => $value) {
                $setting          = Setting::where('key', $key)->first();
                $setting->value   = $value;
                $setting->save();
            }
            
            Cache::forget('settings');

            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }
}

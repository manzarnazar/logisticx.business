<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [];
    }

    public static function customResponse()
    {
        $data = [
            'app_name'         => settings('name'),
            'phone'            => settings('phone'),
            'email'            => settings('email'),
            'light_logo'       => logo(settings('app_light_logo')),
            'dark_logo'        => logo(settings('app_dark_logo')),
            'default_language' => settings('default_language'),
            'currency'         => settings('currency'),

             // 📱 App Version Control
            'latest_app_version'   => settings('latest_app_version'),
            'android_download_url' => settings('android_download_url'),
            'ios_download_url'     => settings('ios_download_url'),
        ];

        return $data;
    }
}

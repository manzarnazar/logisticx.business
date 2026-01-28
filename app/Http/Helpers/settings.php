<?php

// settings helper
//settings

use App\Models\Backend\Upload;
use Illuminate\Support\Carbon;
use App\Models\Backend\Setting;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Cache;
use Modules\Section\Entities\Section;
use App\Models\Backend\MerchantSetting;
use Modules\Language\Entities\Language;

if (!function_exists('settings')) {
    function settings($key = "")
    {
        $settings = Cache::rememberForever("settings", fn() => Setting::pluck('value', 'key')->toArray());

        return data_get($settings, $key);
    }
}

if (!function_exists('merchantSetting')) {
    function merchantSetting($key = "", int $merchant_id = 0)
    {
        $settings = MerchantSetting::where('key', $key)->where('merchant_id', $merchant_id)->first();

        if ($settings) :
            return $settings->value;
        endif;

        $settings = Setting::where('key', $key)->first();
        if ($settings) :
            return $settings->value;
        endif;

        return null;
    }
}
//end settings helpers

if (!function_exists('getImage')) {
    function getImage(Upload|string|int|null $upload, string $version = 'original', string $default_image = 'default-image.png')
    {
        if (!($upload instanceof Upload) && !is_null($upload)) $upload = Upload::find($upload);

        $path = $upload?->{$version} ?? "images/default/$default_image";

        if (File::isFile(public_path($path))) {
            return asset($path);
        }

        return "https://placehold.co/200x200?text=No+Image";
    }
}

//logo
if (!function_exists('logo')) {
    function logo($upload_id = null, string $version = 'original')
    {
        $cacheKey = "logo-{$upload_id}";

        $logo   = Cache::get($cacheKey);

        if ($logo == null || !File::isFile(public_path($logo->{$version}))) {
            Cache::forget($cacheKey);
            $logo = Cache::rememberForever($cacheKey, fn() => Upload::find($upload_id));
        }

        return asset($logo->{$version});
    }
}
//end logo


//favicon
if (!function_exists('favicon')) {
    function favicon($upload_id = null)
    {
        $cacheKey = "favicon-{$upload_id}";

        $favicon   = Cache::get($cacheKey);

        if ($favicon == null || !File::isFile(public_path($favicon->original))) {
            Cache::forget($cacheKey);
            $favicon = Cache::rememberForever($cacheKey, fn() => Upload::find($upload_id));
        }

        return asset($favicon->original);
    }
}
//end favicon


if (!function_exists('customSection')) {
    function customSection($type, $key)
    {

        $sections = Cache::rememberForever('sections', function () {

            $all_sections = Section::with('upload')->select('type', 'key', 'value')->get();
            $sections     = [];

            foreach ($all_sections as $section) {

                if (str_contains($section->key, 'image')) {
                    $sections[$section->type][$section->key] = $section->image;
                } else {
                    $sections[$section->type][$section->key] = $section->value;
                }
            }

            return $sections;
        });

        return data_get($sections, $type . '.' . $key, '');
    }
}


if (!function_exists('defaultLanguage')) {
    function defaultLanguage()
    {
        // Determine the application's locale, falling back to the default language setting or 'en' if not set
        $app_local  = app()->getLocale() ?? settings('language') ?? 'en';

        $cacheKey   = "defaultLanguage-{$app_local}";

        return Cache::remember($cacheKey, Carbon::now()->addMinutes(10), fn() => Language::where('code', $app_local)->first());
    }
}

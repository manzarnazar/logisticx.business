<?php

namespace App\Http\Controllers\Api;

use App\Enums\Status;
use Illuminate\Http\Request;
use App\Models\Backend\Setting;
use Illuminate\Support\Facades\App;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Modules\Language\Entities\Language;
use App\Http\Resources\SettingsResource;
use App\Http\Resources\AppSliderResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\AppLanguagesResource;
use App\Repositories\AppSlider\AppSliderInterface;
use Modules\Language\Repositories\Language\LanguageInterface;

class SettingsController extends Controller
{
    use ApiReturnFormatTrait;

    protected $repoLang, $appSliderRepo;

    public function __construct(LanguageInterface $repoLang, AppSliderInterface $appSliderRepo)
    {
        $this->repoLang = $repoLang;
        $this->appSliderRepo = $appSliderRepo;
    }

    public function appLanguages()
    {
        $languages  = $this->repoLang->all(status: Status::ACTIVE, orderBy: 'code', sortBy: 'asc');

        $data       = AppLanguagesResource::collection($languages);

        return $this->responseWithSuccess(___('alert.request_successfully_executed'), data: $data);
    }

    public function languageTerms(Request $request)
    {
        $validation = Validator::make($request->all(),  ['language_code'  => 'nullable|exists:languages,code']);

        if ($validation->fails()) {
            return $this->responseWithError(___('alert.validation_error'), $validation->errors());
        }

        try {
            $code       = $request->language_code ?: settings('default_language');

            $path       = base_path("lang/{$code}/app-terms.json");

            $jsonString = file_get_contents($path);

            $language   = Language::where('code', $code)->first();

            $data       = [
                'language_name'     => $language->name,
                'language_code'     => $language->code,
                'text_direction'    => $language->text_direction,
                'terms'             => json_decode($jsonString, true),
            ];

            return $this->responseWithSuccess(data: $data);
        } catch (\Throwable $th) {
            return $this->responseWithError(message: ___('alert.something_went_wrong'), code: 500);
        }
    }

    public function appSlider()
    {

        try {
            $slider = $this->appSliderRepo->all(status: status::ACTIVE, paginate: 3);

            $data = AppSliderResource::collection($slider);

            return $this->responseWithSuccess(message: ___('alert.request_successfully_executed'), data: $data);
        } catch (\Throwable $th) {
            return $this->responseWithError(message: ___('alert.something_went_wrong'), code: 500);
        }
    }

    public function settings()
    {

        try {
            $data    = SettingsResource::customResponse();

            return $this->responseWithSuccess(message: ___('alert.request_successfully_executed'), data: $data);
        } catch (\Throwable $th) {
            return $this->responseWithError(message: ___('alert.something_went_wrong'), code: 500);
        }
    }
    public function setLocalization($language)
    {
        App::setLocale($language);
        session()->put('locale', $language);
        return $this->responseWithSuccess(message: ___('alert.request_successfully_executed'));
    }
}

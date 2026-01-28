<?php

namespace Modules\Section\Repositories;

use App\Enums\ImageSize;
use App\Models\Backend\Upload;
use Modules\Section\Enums\Type;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Modules\Section\Entities\Section;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use App\Repositories\Upload\UploadInterface;

class SectionRepository implements SectionInterface
{

    use ReturnFormatTrait;

    protected $model, $upload;

    public function __construct(Section $model, UploadInterface $upload)
    {
        $this->model = $model;
        $this->upload = $upload;
    }

    public function get()
    {
        return Section::select('type', DB::raw('count(*) as total'))->groupBy('type')->paginate(settings('paginate_value'));
    }

    public function getFind($type)
    {
        $sections = Section::select('type', 'key', 'value')->where('type', $type)->get();
        $array = [];
        foreach ($sections as $section) {
            $array[$section->key] = $section->value;
        }
        return $array;
    }

    public function themeAppearance()
    {
        return Section::where('type', Type::THEME_APPEARANCE)->pluck('value', 'key');
    }

    public function update($request)
    {
        // dd($request->all());
        try {

            $ignore    = ['_token', '_method', 'type', 'name'];



            foreach ($request->except($ignore) as $key => $value) {

                $section = $this->model::where('type', $request->type)->where('key', $key)->first();
                // dd($section);


//                 $section = $this->model::firstOrCreate(
//     ['type' => $request->type, 'key' => $key],
//     ['value' => '']  // Default empty value for new records
// );

                if ($request->hasFile($key)) {

                    if ($request->type == Type::BREADCRUMB) {
                        $image_id    = $this->upload->uploadImage(image: $value, path: 'section/', image_sizes: [ImageSize::BREADCRUMB_IMAGE], old_upload_id: $section->value);
                    }
                    elseif ($request->type == Type::HERO_SECTION) {
                        $image_id    = $this->upload->uploadImage(image: $value, path: 'section/', image_sizes: [ImageSize::HERO_SECTION_IMAGE, ImageSize::CLIENT_LOGO], old_upload_id: $section->value);
                    }
                    elseif ($request->type == Type::ABOUT_US) {
                        $image_id    = $this->upload->uploadImage(image: $value, path: 'section/', image_sizes: [ImageSize::ABOUT_US_IMAGE], old_upload_id: $section->value);
                    }
                    elseif ($request->type == Type::OUR_ACHIEVEMENT) {

                        if ($key == 'image_small') {
                            $image_id   = $this->upload->uploadImage(image: $value, path: 'section/', image_sizes: [ImageSize::COUNTER_IMAGE_SMALL], old_upload_id: $section->value);
                        } elseif ($key == 'image_big') {
                            $image_id   = $this->upload->uploadImage(image: $value, path: 'section/', image_sizes: [ImageSize::COUNTER_IMAGE_BIG], old_upload_id: $section->value);
                        } else {
                            $image_id   = $this->upload->uploadImage(image: $value, path: 'section/', image_sizes: [ImageSize::COUNTER_ICON], old_upload_id: $section->value);
                        }
                    }
                     elseif ($request->type == Type::DELIVERY_CALCULATOR) {
                        $image_id    = $this->upload->uploadImage(image: $value, path: 'section/', image_sizes: [ImageSize::DELIVERY_CALCULATION_BG_IMAGE], old_upload_id: $section->value);
                    }
                     elseif ($request->type == Type::DELIVERY_CALCULATOR_TWO) {
                        $image_id    = $this->upload->uploadImage(image: $value, path: 'section/', image_sizes: [ImageSize::DELIVERY_CALCULATION_BG_IMAGE], old_upload_id: $section->value);
                    }
                    elseif ($request->type == Type::FAQ) {
                        $image_id    = $this->upload->uploadImage(image: $value, path: 'section/', image_sizes: [ImageSize::FAQ_IMAGE], old_upload_id: $section->value);
                    }
                    elseif ($request->type == Type::FAQ_STYLE_TWO) {
                        $image_id    = $this->upload->uploadImage(image: $value, path: 'section/', image_sizes: [ImageSize::FAQ_IMAGE], old_upload_id: $section->value);
                    }
                    elseif ($request->type == Type::CTA) {
                        $image_id    = $this->upload->uploadImage(image: $value, path: 'section/', image_sizes: [ImageSize::FAQ_IMAGE], old_upload_id: $section->value);
                    }
                    elseif ($request->type == Type::HOW_WE_WORK) {
                        $image_id    = $this->upload->uploadImage(image: $value, path: 'section/', image_sizes: [ImageSize::COVERAGE_AREA_BG_IMAGE], old_upload_id: $section->value);
                    }
                    elseif ($request->type == Type::CONTACT_US) {
                        $image_id    = $this->upload->uploadImage(image: $value, path: 'section/', image_sizes: [ImageSize::COVERAGE_AREA_BG_IMAGE], old_upload_id: $section->value);
                    }
                    elseif ($request->type == Type::COVERAGE_AREA) {
                        $image_id    = $this->upload->uploadImage(image: $value, path: 'section/', image_sizes: [ImageSize::COVERAGE_AREA_BG_IMAGE], old_upload_id: $section->value);
                    }
                    elseif ($request->type == Type::SIGNIN) {
                        $image_id    = $this->upload->uploadImage(image: $value, path: 'section/', image_sizes: [ImageSize::SIGNIN_IMAGE], old_upload_id: $section->value);
                    }
                    elseif ($request->type == Type::FEATURES) {
                        $image_id    = $this->upload->uploadImage(image: $value, path: 'section/', image_sizes: [ImageSize::SIGNIN_IMAGE], old_upload_id: $section->value);
                    }
                     elseif ($request->type == Type::SIGNUP) {
                        $image_id    = $this->upload->uploadImage(image: $value, path: 'section/', image_sizes: [ImageSize::SIGNUP_IMAGE], old_upload_id: $section->value);
                    }

                    $section->value = $image_id;
                } else {
                    $section->value   = $value;
                }

                $section->save();

                // if ($request->hasFile($key)) {
                //     $upload = Upload::find($section->value);
                //     dd($upload);
                // }
            }

            Session::forget('sections');
            Cache::forget('sections');

            Artisan::call("optimize:clear");

            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }
}

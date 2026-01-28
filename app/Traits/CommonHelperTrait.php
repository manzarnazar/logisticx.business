<?php

namespace App\Traits;

use App\Enums\Status;
use Illuminate\Support\Facades\File;

trait CommonHelperTrait
{

    public function getMyStatusAttribute()
    {
        if ($this->status == Status::ACTIVE) {
            $status = '<span class="bullet-badge bullet-badge-success">' . ___("common." . config('site.status.default.' . Status::ACTIVE)) . '</span>';
        } elseif ($this->status == Status::INACTIVE) {
            $status = '<span class="bullet-badge bullet-badge-danger">' . ___("common." . config('site.status.default.' . Status::INACTIVE)) . '</span>';
        } else {
            $status = '<span class="bullet-badge bullet-badge-danger">' . ___("common.unknown") . '</span>';
        }
        return $status;
    }

    protected function modelImageProcessor($images, $defaultImages)
    {

        $data = $defaultImages;

        if ($images  && $images->original['original'] && File::exists(public_path($images->original['original']))) :
            $data['original'] = asset($images->original['original']);
        endif;
        if ($images  && $images->original['image_one'] && File::exists(public_path($images->original['image_one']))) :
            $data['image_one'] = asset($images->original['image_one']);
        endif;
        if ($images  && $images->original['image_two'] && File::exists(public_path($images->original['image_two']))) :
            $data['image_two'] = asset($images->original['image_two']);
        endif;
        if ($images  && $images->original['image_three'] && File::exists(public_path($images->original['image_three']))) :
            $data['image_three'] = asset($images->original['image_three']);
        endif;
        // if ($images  && $images->original['image_four'] && File::exists(public_path($images->original['image_four']))) :
        //     $data['image_four'] = asset($images->original['image_four']);
        // endif;

        return $data;
    }
}

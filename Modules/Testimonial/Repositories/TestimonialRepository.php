<?php

namespace Modules\Testimonial\Repositories;

use App\Enums\Status;
use App\Enums\ImageSize;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\Cache;
use App\Repositories\Upload\UploadInterface;
use Modules\Testimonial\Entities\Testimonial;
use Modules\Testimonial\Repositories\TestimonialInterface;

class TestimonialRepository implements TestimonialInterface
{
    use ReturnFormatTrait;

    protected $model, $upload;

    public function __construct(Testimonial $model, UploadInterface $upload)
    {
        $this->model    = $model;
        $this->upload   = $upload;
    }


    public function all(string $orderBy = 'id', string $sortBy = 'desc')
    {
        return $this->model::orderBy($orderBy, $sortBy)->paginate(settings('paginate_value'));
    }
    public function activeTestimonial()
    {
        return $this->model::where('status', Status::ACTIVE)->get();
    }
    public function get(string $orderBy = 'id', string $sortBy = 'desc')
    {
        return $this->model::orderBy($orderBy, $sortBy)->get();
    }

    public function getFind($id)
    {
        return $this->model::find($id);
    }

    public function store($request)
    {
        try {
            $testimonial                    = new $this->model;
            $testimonial->client_name       = $request->client_name;
            $testimonial->designation       = $request->designation;
            $testimonial->image             = $this->upload->uploadImage($request->image, 'testimonial/', [ImageSize::TESTIMONIAL_CLIENT_IMAGE, ImageSize::IMAGE_40x40], '');
            $testimonial->rating            = $request->rating;
            $testimonial->description       = $request->description;
            $testimonial->position          = $request->position;
            $testimonial->status            = $request->status ?? Status::INACTIVE;
            $testimonial->save();

            Cache::forget('testimonials');
            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }
    public function update($request, $id)
    {
        try {
            $testimonial                    = $this->model::find($id);
            $testimonial->client_name       = $request->client_name;
            $testimonial->designation       = $request->designation;
            $testimonial->image             = $this->upload->uploadImage($request->image, 'testimonial/', [ImageSize::TESTIMONIAL_CLIENT_IMAGE, ImageSize::IMAGE_40x40], $testimonial->image);
            $testimonial->rating            = $request->rating;
            $testimonial->description       = $request->description;
            $testimonial->position          = $request->position;
            $testimonial->status            = $request->status ?? Status::INACTIVE;
            $testimonial->save();

            Cache::forget('testimonials');
            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }


    public function delete($id)
    {
        try {
            $testimonial = $this->model::find($id);
            $this->upload->deleteImage($testimonial->image, 'delete');
            $this->model::destroy($id);

            Cache::forget('testimonials');
            return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function statusUpdate($id)
    {
        try {
            $banner  = $this->model::find($id);

            if ($banner->status == Status::ACTIVE) :
                $banner->status = Status::INACTIVE;
            elseif ($banner->status == Status::INACTIVE) :
                $banner->status = Status::ACTIVE;
            endif;

            $banner->save();

            return $this->responseWithSuccess(___('alert.successfully_status_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }
}

<?php

namespace Modules\Features\Repositories\Features;

use App\Enums\Status;
use App\Enums\ImageSize;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\Cache;
use Modules\Features\Entities\Features;
use App\Repositories\Upload\UploadInterface;
use Modules\Features\Repositories\Features\FeaturesInterface;

class FeaturesRepository implements FeaturesInterface
{
    use ReturnFormatTrait;

    protected $model, $upload;

    public function __construct(Features $model, UploadInterface $upload)
    {
        $this->model = $model;
        $this->upload = $upload;
    }

    public function all(string $orderBy = 'id', string $sortBy = 'desc')
    {
        return $this->model::where('status', Status::ACTIVE)->orderBy($orderBy, $sortBy)->paginate(settings('paginate_value'));
    }

    public function get(string $orderBy = 'id', string $sortBy = 'desc')
    {
        return $this->model::orderBy($orderBy, $sortBy)->paginate(settings('paginate_value'));
    }

    public function getFind($id)
    {
        return $this->model::findOrFail($id);
    }

    public function store($request)
    {
        try {

            $features              = new $this->model;
            $features->title       = $request->title;
            $features->image       = $this->upload->uploadImage($request->image, 'features/', [ImageSize::IMAGE_100x100, ImageSize::IMAGE_80x80, ImageSize::IMAGE_370x240], '');
            $features->description = $request->description;
            $features->position    = $request->position;
            $features->status      = $request->status ?? Status::INACTIVE;
            $features->save();

            Cache::forget('features');

            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($request, $id)
    {
        try {

            $features              = $this->model::findOrFail($id);
            $features->title       = $request->title;
            $features->image       = $this->upload->uploadImage($request->image, 'features/', [ImageSize::IMAGE_100x100, ImageSize::IMAGE_80x80, ImageSize::IMAGE_370x240], $features->image);
            $features->description = $request->description;
            $features->position    = $request->position;
            $features->status      = $request->status ?? Status::INACTIVE;
            $features->save();

            Cache::forget('features');
            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function delete($id)
    {
        try {
            $features =   $this->model::find($id);
            $this->upload->deleteImage($features->image, 'delete');
            $features->delete($id);

            Cache::forget('features');
            return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function statusUpdate($id)
    {
        try {
            $features                 = $this->model::find($id);
            if ($features->status     == Status::ACTIVE) :
                $features->status     = Status::INACTIVE;
            elseif ($features->status == Status::INACTIVE) :
                $features->status     = Status::ACTIVE;
            endif;
            $features->save();

            return $this->responseWithSuccess(___('alert.successfully_status_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }
}

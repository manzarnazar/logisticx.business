<?php

namespace App\Repositories\AppSlider;


use App\Enums\Status;
use App\Models\Backend\AppSlider;
use App\Traits\ReturnFormatTrait;
use App\Repositories\Upload\UploadInterface;
use App\Repositories\AppSlider\AppSliderInterface;

class AppSliderRepository implements AppSliderInterface
{
    use ReturnFormatTrait;

    private $model, $upload;

    public function __construct(AppSlider $model, UploadInterface $upload)
    {
        $this->model = $model;
        $this->upload = $upload;
    }

    public function all(bool $status = null, int $paginate = null, string $orderBy = 'id', string $sortBy = 'desc')
    {
        $query = $this->model::query();

        if ($status != null) {
            $query->where('status', $status);
        }

        if ($paginate !== null) {
            return  $query->paginate($paginate);
        } else {
            return $query->get();
        }

    }
    public function get($id)
    {
        return  $this->model::findOrFail($id);
    }

    public function store($request)
    {
        try {

            $appSlider                  = $this->model;
            $appSlider->title           = $request->title;
            $appSlider->position        = $request->position;
            $appSlider->description     = $request->description;
            $appSlider->image_id        = $this->upload->uploadImage($request->image, 'app_sliders/', [],null);
            $appSlider->status          = $request->status;
            $appSlider->save();


            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($request)
    {
        try {
            $appSlider                  = $this->get($request->id);
            $appSlider->title           = $request->title;
            $appSlider->position        = $request->position;
            $appSlider->description     = $request->description;
            $appSlider->image_id        = $this->upload->uploadImage($request->image, 'app_sliders/', [], $appSlider->image_id);
            $appSlider->status          = $request->status;
            $appSlider->save();

            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function delete($id)
    {
        $this->model::destroy($id);
        return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
    }



}

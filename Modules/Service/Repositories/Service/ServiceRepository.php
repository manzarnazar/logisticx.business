<?php

namespace Modules\Service\Repositories\Service;

use App\Enums\Status;
use App\Enums\ImageSize;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Modules\Service\Entities\Service;
use App\Repositories\Upload\UploadInterface;

class ServiceRepository implements ServiceInterface
{
    use ReturnFormatTrait;

    protected $model, $upload;

    public function __construct(Service $model, UploadInterface $upload)
    {
        $this->model = $model;
        $this->upload = $upload;
    }

    public function all(string $orderBy = 'id', string $sortBy = 'desc')
    {
        return $this->model::orderBy($orderBy, $sortBy)->paginate(8);
    }

    public function get($id)
    {
        return $this->model::findOrFail($id);
    }

    public function store($request)
    {

        try {
            DB::beginTransaction();

            $service                    = new $this->model;
            $service->title             = $request->title;
            $service->short_description = $request->short_description;
            $service->description = $request->description;
            $service->position          = $request->position;
            $service->status            = $request->status ?? Status::INACTIVE;
            $service->image             = $this->upload->uploadImage($request->image, 'service/', [ImageSize::IMAGE_80x80, ImageSize::IMAGE_370x240], '');
            $service->banner_image      = $this->upload->uploadImage($request->banner_image, 'service/', [ImageSize::IMAGE_80x80, ImageSize::IMAGE_370x240], '');
            $service->save();

            Cache::forget('services');
            DB::commit();
            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($request)
    {
        try {
            DB::beginTransaction();

            $service                    = $this->model::findOrFail($request->id);
            $service->title             = $request->title;
            $service->short_description = $request->short_description;
            $service->description = $request->description;
            $service->position          = $request->position;
            $service->status            = $request->status ?? Status::INACTIVE;
            $service->image             = $this->upload->uploadImage($request->image, 'service/', [ImageSize::IMAGE_80x80, ImageSize::IMAGE_370x240],  $service->image);
            $service->banner_image      = $this->upload->uploadImage($request->banner_image, 'service/', [ImageSize::IMAGE_80x80, ImageSize::IMAGE_370x240],  $service->banner_image);
            $service->save();

            Cache::forget('services');
            DB::commit();
            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function delete($id)
    {
        try {

            $service = $this->get($id);
            $this->upload->deleteImage($service->image, 'delete');
            $service->delete();

            Cache::forget('services');
            return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }



    public function statusUpdate($id)
    {
        try {
            $service            = $this->model::findOrFail($id);
            $service->status    = $service->status == Status::ACTIVE ? Status::INACTIVE : Status::ACTIVE;
            $service->save();

            return $this->responseWithSuccess(___('alert.successfully_status_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }
    public function getServiseTypes($request)
    {
        return $this->model::orderBy($orderBy, $sortBy)->paginate(8);
    }
}

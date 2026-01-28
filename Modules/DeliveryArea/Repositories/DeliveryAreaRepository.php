<?php

namespace Modules\DeliveryArea\Repositories;

use App\Enums\Status;
use App\Enums\ImageSize;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\Cache;
use App\Repositories\Upload\UploadInterface;
use Modules\DeliveryArea\Entities\DeliveryArea;

class DeliveryAreaRepository implements DeliveryAreaInterface
{
    use ReturnFormatTrait;

    protected $model, $upload;

    public function __construct(DeliveryArea $model, UploadInterface $upload)
    {
        $this->model = $model;
        $this->upload = $upload;
    }

    public function all(bool $status = null, $search = null, int $paginate = null, string $orderBy = 'id', $sortBy = 'desc')
    {
        $query = $this->model::query();
        $query->with('upload');

        if ($status !== null) {
            $query->where('status', $status);
        }

        if ($search !== null) {
            $query->where(fn($query) => $query->where('title', 'like', "%{$search}%")->orWhere('description', 'like', "%{$search}%"));
        }

        $query->orderBy($orderBy, $sortBy);

        return $paginate ? $query->paginate($paginate) : $query->get();
    }

    public function get()
    {
        return $this->model::all();
    }

    public function getFind($id)
    {
        return $this->model::findOrFail($id);
    }

    public function store($request)
    {
        try {
            $gallery                        = new $this->model();
            $gallery->title                 = $request->title;
            $gallery->short_description     = $request->short_description;
            $gallery->position              = $request->position;
            $gallery->status                = $request->status ?? Status::INACTIVE;
            $gallery->image_id              = $this->upload->uploadImage($request->image, 'gallery',  [ImageSize::BLOG_IMAGE_ONE, ImageSize::BLOG_IMAGE_TWO, ImageSize::BLOG_IMAGE_THREE], '');
            $gallery->save();

            Cache::forget('galleries');

            return $this->responseWithSuccess(__('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(__('alert.something_went_wrong'), []);
        }
    }

    public function update($request, $id)
    {

        try {
            $gallery                       = $this->model::findOrFail($id);
            $gallery->title                = $request->title;
            $gallery->short_description    = $request->short_description;
            $gallery->position             = $request->position;
            $gallery->status               = $request->status ?? Status::INACTIVE;
            $gallery->image_id             = $this->upload->uploadImage($request->image, 'gallery/', [ImageSize::BLOG_IMAGE_ONE, ImageSize::BLOG_IMAGE_TWO, ImageSize::BLOG_IMAGE_THREE], $gallery->image_id);
            $gallery->save();

            Cache::forget('galleries');

            return $this->responseWithSuccess(__('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(__('alert.something_went_wrong'), []);
        }
    }

    public function delete($id)
    {
        try {
            $gallery = $this->model::find($id);
            if ($gallery) {
                $this->upload->deleteImage($gallery->image_id, 'delete');
                $gallery->delete();
                Cache::forget('galleries');
                return $this->responseWithSuccess(__('alert.successfully_deleted'), []);
            }
            return $this->responseWithError(__('alert.not_found'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(__('alert.something_went_wrong'), []);
        }
    }
}

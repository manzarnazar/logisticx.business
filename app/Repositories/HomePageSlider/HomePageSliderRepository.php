<?php

namespace App\Repositories\HomePageSlider;
use App\Enums\Status;
use App\Enums\ImageSize;
use Illuminate\Support\Str;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\Cache;
use App\Repositories\Upload\UploadInterface;
use App\Models\HomePageSlider;

class HomePageSliderRepository implements HomePageSliderInterface
{
     use ReturnFormatTrait;

    protected $model, $upload;

     public function __construct(HomePageSlider $model, UploadInterface $upload)
    {
        $this->model = $model;
        $this->upload = $upload;
    }

    public function all(int $status = null, array $column = [], int $paginate = null, string $orderBy = 'id', string $sortBy = 'desc')
    {
        $query = $this->model::query();

        if ($status !== null) {
            $query->where('status', $status);
        }

        $query->orderBy($orderBy, $sortBy);

        if (!empty($column)) {
            $query->select($column);
        }

        if ($paginate !== null) {
            return  $query->paginate($paginate);
        } else {
            return $query->get();
        }
    }

    public function get($id)
    {
        return $this->model::findOrFail($id);
    }

    public function store($request)
    {

        //dd($request->all());
        try {
            $data           = $this->model;

            $data->small_title     = $request->small_title;
            $data->title     = $request->title;
            $data->description     = $request->description;
            $data->page_link     = $request->page_link;
            $data->video_link     = $request->video_link;
            $data->position = $request->position  != null ? $request->position : false;
            $data->status      = $request->status  ?? false;

            $data->banner = $this->upload->uploadImage($request->banner,'home_page_sliders/',[]);

            $data->date        = $request->date;

            $data->save();

            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

     public function update($request)
    {

        try {
            $data           = $this->get($request->id);
            $data->small_title     = $request->small_title;
            $data->title     = $request->title;
            $data->description     = $request->description;
            $data->page_link     = $request->page_link;
            $data->video_link     = $request->video_link;
            $data->position = $request->position != null ? $request->position : false;
            $data->status   = $request->status ?? false;
            $data->banner      = $this->upload->uploadImage($request->banner, 'home_page_sliders/',
                [], $data->banner);
            $data->date        = $request->date;
            $data->save();

            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }


      public function delete($id)
    {
        try {
            $item  = $this->model::findOrFail($id);

            $this->upload->deleteImage($item->banner, 'delete');

            $item->delete($id);

            return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }
}

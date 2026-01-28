<?php

namespace Modules\Blog\Repositories\Blog;

use App\Enums\Status;
use App\Enums\ImageSize;
use Illuminate\Support\Str;
use Modules\Blog\Entities\Blog;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\Cache;
use App\Repositories\Upload\UploadInterface;
use Modules\Blog\Repositories\Blog\BlogInterface;

class BlogRepository implements BlogInterface
{
    use ReturnFormatTrait;

    protected $model, $upload;

    public function __construct(Blog $model, UploadInterface $upload)
    {
        $this->model = $model;
        $this->upload = $upload;
    }

    public function all(bool $status = null, $search = null, int $paginate = null, string $orderBy = 'id', $sortBy = 'desc')
    {
        $query = $this->model::query();
        $query->with('upload', 'user');

        if ($status != null) {
            $query->where('status', $status);
        }

        if ($search != null) {
            $query->where(fn ($query) => $query->where('title', 'like', "%{$search}%")->orWhere('description', 'like', "%{$search}%"));
        }

        $query->orderBy($orderBy, $sortBy);

        if ($paginate != null) {
            return  $query->paginate($paginate);
        }

        return $query->get();
    }

    public function get()
    {
        return $this->model::with('user:id,name')->orderBy('id', 'desc')->get();
    }

    public function getFind($id)
    {
        return $this->model::findOrFail($id);
    }

    public function findBySlug($slug)
    {
        return $this->model::where('slug', $slug)->firstOrFail();
    }

    public function store($request)
    {
        try {
            $blog              = new $this->model();
            $blog->author      = $request->author;
            $blog->title       = $request->title;
            $blog->slug        = Str::slug($blog->title);
            $blog->date        = $request->date;
            $blog->status      = $request->status ?? Status::INACTIVE;
            $blog->description = $request->description;
            $blog->position    = $request->position;
            $blog->banner      = $this->upload->uploadImage($request->banner, 'blog/', [ImageSize::BLOG_IMAGE_ONE, ImageSize::BLOG_IMAGE_TWO, ImageSize::BLOG_IMAGE_THREE], null);
            $blog->save();


            Cache::forget('blogs');
            Cache::forget('recent_blogs');

            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($request, $id)
    {
        try {
            $blog              = $this->model::findOrFail($id);
            $blog->author      = $request->author;
            $blog->title       = $request->title;
            $blog->slug        = Str::slug($blog->title);
            $blog->date        = $request->date;
            $blog->status      = $request->status ?? Status::INACTIVE;
            $blog->description = $request->description;
            $blog->position    = $request->position;
            $blog->banner      = $this->upload->uploadImage($request->banner, 'blog/', [ImageSize::BLOG_IMAGE_ONE, ImageSize::BLOG_IMAGE_TWO, ImageSize::BLOG_IMAGE_THREE], $blog->banner);
            $blog->save();

            Cache::forget('blogs');
            Cache::forget('recent_blogs');

            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function delete($id)
    {
        try {
            $blog =   $this->model::find($id);
            $this->upload->deleteImage($blog->banner, 'delete');
            $blog->delete($id);

            Cache::forget('blogs');
            Cache::forget('recent_blogs');

            return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function statusUpdate($id)
    {
        try {
            $blog                 = $this->model::find($id);
            if ($blog->status     == Status::ACTIVE) :
                $blog->status     = Status::INACTIVE;
            elseif ($blog->status == Status::INACTIVE) :
                $blog->status     = Status::ACTIVE;
            endif;
            $blog->save();

            return $this->responseWithSuccess(___('alert.successfully_status_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }
}

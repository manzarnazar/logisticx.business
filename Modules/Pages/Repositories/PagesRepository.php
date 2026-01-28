<?php

namespace Modules\Pages\Repositories;

use App\Enums\Status;
use Modules\Pages\Entities\Page;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\Cache;
use Modules\Pages\Repositories\PagesInterface;

class PagesRepository implements PagesInterface
{
    use ReturnFormatTrait;

    protected $model;

    public function __construct(Page $model)
    {
        $this->model = $model;
    }

    public function all(string $orderBy = 'id', string $sortBy = 'desc')
    {
        return $this->model::orderByDesc($orderBy, $sortBy)->paginate(settings('paginate_value'));
    }

    public function get($id)
    {
        return $this->model::findOrFail($id);
    }

    public function page($page)
    {
        return  $this->model::where('page', $page)->first();
    }

    public function pageDetails($page_slug)
    {
        return $this->model::where(['page' => $page_slug, 'status' => Status::ACTIVE])->first();
    }

    public function update($request, $id)
    {
        try {
            $page               = $this->model::findOrFail($id);
            $page->page         = $request->page;
            $page->title        = $request->title;
            $page->description  = $request->description;
            $page->status       = $request->status ?? Status::INACTIVE;
            $page->save();

            Cache::forget('about_us');
            Cache::forget('privacy_policy');
            Cache::forget('terms_conditions');

            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }
}

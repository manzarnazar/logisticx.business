<?php

namespace Modules\Faq\Repositories;

use Tests\TestCase;
use App\Enums\Status;
use Modules\Faq\Entities\Faq;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\Cache;
use Modules\Faq\Repositories\FaqInterface;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FaqRepository implements FaqInterface
{
    use ReturnFormatTrait;

    protected $model;

    public function __construct(Faq $model)
    {
        $this->model = $model;
    }

    public function all(string $orderBy = 'id', string $sortBy = 'desc')
    {
        return $this->model->orderBy($orderBy, $sortBy)->paginate(settings('paginate_value'));
    }

    public function activeFaq()
    {
        return $this->model->where('status', Status::ACTIVE)->orderBy('position', 'asc')->get()->take(3);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function store($request)
    {
        try {
            $service               = new $this->model;
            $service->title        = $request->title;
            $service->position     = $request->position;
            $service->description  = $request->description;
            $service->icon         = $request->icon;
            $service->status       = $request->status;
            $service->save();

            Cache::forget('faqs');

            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($request, $id)
    {
        try {
            $service               = $this->model->find($id);
            $service->title        = $request->title;
            $service->position     = $request->position;
            $service->description  = $request->description;
            $service->icon         = $request->icon;
            $service->status       = $request->status;
            $service->save();

            Cache::forget('faqs');
            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function destroy($id)
    {
        $this->model::destroy($id);
        Cache::forget('faqs');
        return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
    }

    public function statusUpdate($id)
    {
        try {
            $service                = $this->model->find($id);
            if ($service->status     == Status::ACTIVE) :
                $service->status    = Status::INACTIVE;
            elseif ($service->status == Status::INACTIVE) :
                $service->status    = Status::ACTIVE;
            endif;
            $service->save();

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }
}

<?php

namespace App\Repositories\ServiceFaq;
use App\Models\Backend\Charges\ServiceType;
use App\Traits\ReturnFormatTrait;
use App\Models\ServiceFaq;

class ServiceFaqRepository implements ServiceFaqInterface
{
    use ReturnFormatTrait;
    private $model;

    public function __construct(ServiceFaq $model)
    {
        $this->model = $model;
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
        try {
            $data           = $this->model;
            $data->title     = $request->title;
            $data->service_id       = $request->service_id;
            $data->description = $request->description;
            $data->position = $request->position != null ? $request->position : false;
            $data->status   = $request->status ?? false;
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
            $data->title     = $request->title;
            $data->service_id     = $request->service_id;
            $data->description = $request->description;
            $data->position = $request->position != null ? $request->position : false;
            $data->status   = $request->status ?? false;
            $data->save();

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

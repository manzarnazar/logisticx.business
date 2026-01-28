<?php

namespace App\Repositories\ValueAddedService;

use App\Enums\Status;
use App\Traits\ReturnFormatTrait;
use App\Models\Backend\Charges\ValueAddedService;

class VASRepository implements VASInterface
{
    use ReturnFormatTrait;
    private $model;

    public function __construct(ValueAddedService $model)
    {
        $this->model = $model;
    }

    public function all(bool $status = null, array $column = [], int $paginate = null, $orderBy = 'position')
    {
        $query = $this->model::query();

        if ($status !== null) {
            $query->where('status', $status);
        }

        $query->orderBy($orderBy, 'desc');

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
            $data->name     = $request->name;
            $data->price    = $request->price;
            $data->position = $request->position != null ? $request->position : 0;
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
            $data->name     = $request->name;
            $data->price    = $request->price;
            $data->position = $request->position != null ? $request->position : 0;
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

    public function getWithFilter($skipIDs = [], array $where = [], array $columns = ['*'], $retrieveFirst = false)
    {
        $query = $this->model::query();

        if (!empty($skipIDs)) {
            $query->whereNotIn('id', $skipIDs);
        }

        $where['status'] = $where['status'] ?? Status::ACTIVE;

        $query->where($where);

        $query->select($columns);

        $query->distinct();

        if ($retrieveFirst) {
            return $query->first();
        } else {
            return $query->get();
        }
    }
}

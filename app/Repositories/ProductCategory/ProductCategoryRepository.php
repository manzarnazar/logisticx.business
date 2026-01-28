<?php

namespace App\Repositories\ProductCategory;

use App\Traits\ReturnFormatTrait;
use App\Models\Backend\Charges\ProductCategory;

class ProductCategoryRepository implements ProductCategoryInterface
{
    use ReturnFormatTrait;
    private $model;

    public function __construct(ProductCategory $model)
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

    public function single($id)
    {
        return $this->model::find($id);
    }

    public function store($request)
    {
        try {
            $model           = $this->model;
            $model->name     = $request->name;
            $model->position = $request->position != null ? $request->position : false;
            $model->status   = $request->status ?? false;
            $model->save();
            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($request)
    {
        try {
            $model           = $this->model::find($request->id);
            $model->name     = $request->name;
            $model->position = $request->position != null ? $request->position : false;
            $model->status   = $request->status ?? false;
            $model->save();
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

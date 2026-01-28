<?php

namespace App\Repositories\Bank;


use App\Enums\Status;
use App\Models\Backend\Bank;
use App\Traits\ReturnFormatTrait;
use App\Repositories\Bank\BankInterface;


class BankRepository implements BankInterface
{
    use ReturnFormatTrait;

    protected $model;

    public function __construct(Bank $model)
    {
        $this->model = $model;
    }

    public function all(bool $status = null, int $paginate = null, string $orderBy = 'id', $sortBy = 'desc')
    {
        $query = $this->model::query();

        if ($status != null) {
            $query->where('status', $status);
        }

        $query->orderBy($orderBy, $sortBy);

        if ($paginate != null) {
            return  $query->paginate($paginate);
        } else {
            return $query->get();
        }
    }

    public function get($id)
    {
        return $this->model::find($id);
    }

    public function store($request)
    {
        try {
            $banks              = new $this->model;
            $banks->bank_name   = $request->bank_name;
            $banks->position    = $request->position;
            $banks->status      = $request->status ?? Status::INACTIVE;
            $banks->save();

            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($request, $id)
    {

        try {
            $banks              = $this->model::findOrFail($id);
            $banks->bank_name   = $request->bank_name;
            $banks->position    = $request->position;
            $banks->status      = $request->status ?? Status::INACTIVE;
            $banks->save();

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

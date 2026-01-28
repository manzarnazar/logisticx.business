<?php

namespace App\Repositories\Hub;

use App\Models\Backend\Hub;
use App\Models\Backend\Parcel;
use App\Repositories\Hub\HubInterface;
use App\Traits\ReturnFormatTrait;
use Carbon\Carbon;

class HubRepository implements HubInterface
{
    use ReturnFormatTrait;

    protected $model;

    public function __construct(Hub $model)
    {
        $this->model = $model;
    }

    public function all(bool $status = null, string $orderBy = 'id', string $sortBy = 'desc', int $paginate = null)
    {

        $query = $this->model::query();

        if ($status != null) {
            $query->where('status', $status);
        }

        $query->orderBy($orderBy, $sortBy);

        if ($paginate != null) {
            return $query->paginate($paginate);
        } else {
            return $query->get();
        }
    }

    public function filter($request, int $paginate = null)
    {
        $query = $this->model::query();

        if ($request->status != null) {
            $query->where('status', $request->status);
        }

        if ($request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
            $query->orderBy('name', 'asc');
        }

        if ($request->phone) {
            $query->where('phone', 'like', '%' . $request->phone . '%');
            $query->orderBy('phone', 'asc');
        }

        if ($paginate != null) {
            return $query->paginate($paginate);
        }
        return $query->get();
    }

    public function hubs()
    {
        return $this->model::all();
    }

    public function get($id)
    {
        return $this->model::find($id);
    }

    public function store($request)
    {
        try {
            $hub                = new $this->model();
            $hub->name          = $request->name;
            $hub->phone         = $request->phone;
            $hub->address       = $request->address;
            $hub->coverage_id   = $request->coverage;
            $hub->status        = $request->status;
            $hub->save();

            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }
    public function update($id, $request)
    {
        try {
            $hub                = $this->model::find($id);
            $hub->name          = $request->name;
            $hub->phone         = $request->phone;
            $hub->address       = $request->address;
            $hub->coverage_id   = $request->coverage;
            $hub->status        = $request->status;
            $hub->save();
            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function delete($id)
    {
        try {
            $this->model::destroy($id);
            return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
        } catch (\Throwable $th) {

            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

}

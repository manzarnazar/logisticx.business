<?php

namespace App\Repositories\PickupSlot;

use App\Enums\Status;
use App\Traits\ReturnFormatTrait;
use App\Models\Backend\Setting\PickupSlot;

class PickupSlotRepository implements PickupSlotInterface
{
    use ReturnFormatTrait;
    private $model;


    public function __construct(PickupSlot $model)
    {
        $this->model = $model;
    }

    public function all(int $status = null, array $column = [], int $paginate = null, string $orderBy = 'position')
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
        return  $this->model::findOrFail($id);
    }

    public function store($request)
    {
        try {
            $pickup                 = $this->model;
            $pickup->title          = $request->title;
            $pickup->start_time     = $request->start_time;
            $pickup->end_time       = $request->end_time;
            $pickup->position       = $request->position != null ? $request->position : 0;
            $pickup->status         = $request->status ?? Status::INACTIVE;
            $pickup->save();

            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($request)
    {
        try {
            $pickup                 = $this->get($request->id);
            $pickup->title          = $request->title;
            $pickup->start_time     = $request->start_time;
            $pickup->end_time       = $request->end_time;
            $pickup->position       = $request->position != null ? $request->position : 0;
            $pickup->status         = $request->status ?? Status::INACTIVE;
            $pickup->save();

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

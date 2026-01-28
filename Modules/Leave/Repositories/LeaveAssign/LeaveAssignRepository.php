<?php

namespace Modules\Leave\Repositories\LeaveAssign;


use App\Enums\Status;
use App\Traits\ReturnFormatTrait;
use Modules\Leave\Entities\LeaveAssign;
use Modules\Leave\Repositories\LeaveAssign\LeaveAssignInterface;



class LeaveAssignRepository implements LeaveAssignInterface
{
    use ReturnFormatTrait;

    protected $model;

    public function __construct(LeaveAssign $model)
    {
        $this->model = $model;
    }

    public function all(int $status = null, int $paginate = null, string $orderBy = 'position', $sortBy = 'desc')
    {
        $query = $this->model::query();

        if ($status !== null) {
            $query->where('status', $status);
        }

        $query->orderBy($orderBy, $sortBy);

        if ($paginate !== null) {
            return  $query->paginate($paginate);
        } else {
            return $query->get();
        }
    }


    public function activeLeaveAssign()
    {
        return $this->model->where('status', Status::ACTIVE)->orderBy('position', 'desc')->get()->take(3);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function store($request)
    {
        try {
            $exists = $this->model::where('department_id', $request->department_id)->where('type_id', $request->type_id)->exists();
            if ($exists) {
                return $this->responseWithError(___('alert.already_exists'), []);
            }

            $leave_assign               = new $this->model;

            $leave_assign->department_id = $request->department_id;
            $leave_assign->type_id = $request->type_id;
            $leave_assign->days = $request->days;
            $leave_assign->position = $request->position;
            $leave_assign->status = $request->status;
            $leave_assign->save();

            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($request)
    {
        try {
            $exists = $this->model::where('department_id', $request->department_id)->where('type_id', $request->type_id)->whereNot('id', $request->id)->exists();
            if ($exists) {
                return $this->responseWithError(___('alert.already_exists'), []);
            }

            $leave_assign               = $this->model->find($request->id);

            $leave_assign->department_id = $request->department_id;
            $leave_assign->type_id = $request->type_id;
            $leave_assign->days = $request->days;
            $leave_assign->position = $request->position;
            $leave_assign->status = $request->status;
            $leave_assign->save();

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

<?php

namespace Modules\Leave\Repositories\LeaveType;


use App\Enums\Status;
use App\Traits\ReturnFormatTrait;
use Modules\Leave\Entities\LeaveType;
use Modules\Leave\Repositories\LeaveType\LeaveTypeInterface;



class LeaveTypeRepository implements LeaveTypeInterface
{
    use ReturnFormatTrait;

    protected $model;

    public function __construct(LeaveType $model)
    {
        $this->model = $model;
    }

    public function all(string $orderBy = 'id', string $sortBy = 'desc')
    {
        return $this->model->orderBy($orderBy, $sortBy)->paginate(settings('paginate_value'));
    }

    public function activeLeaveType()
    {
        return $this->model->where('status', Status::ACTIVE)->orderBy('position', 'asc')->paginate(8);
    }

    public function find($id)
    {
        return $this->model->find($id);
    }

    public function store($request)
    {
        try {
            $leave_type               = new $this->model;
            $leave_type->name        = $request->name;
            $leave_type->position     = $request->position;
            $leave_type->status       = $request->status;
            $leave_type->save();

            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($request)
    {
        try {
            $leave_type               = $this->model->find($request->id);
            $leave_type->name         = $request->name;
            $leave_type->position     = $request->position;
            $leave_type->status       = $request->status;
            $leave_type->save();

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

    public function statusUpdate($id)
    {
        try {
            $leave_type                = $this->model->find($id);
            if ($leave_type->status     == Status::ACTIVE) :
                $leave_type->status    = Status::INACTIVE;
            elseif ($leave_type->status == Status::INACTIVE) :
                $leave_type->status    = Status::ACTIVE;
            endif;
            $leave_type->save();

            return true;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function getWithFilter(array $where = [], array $columns = ['*'],  int $paginate = null)
    {
        $query = $this->model::query();

        $where['status'] = $where['status'] ?? Status::ACTIVE;

        $query->where($where);

        // Select the specified columns
        $query->select($columns);

        $query->orderBy('name', 'asc');
        // $query->orderBy('name', 'desc');

        if ($paginate !== null) {
            return  $query->paginate($paginate);
        } else {
            return $query->get();
        }
    }
}

<?php

namespace App\Repositories\Department;

use App\Enums\Status;
use App\Models\Backend\Department;
use App\Traits\ReturnFormatTrait;
use App\Repositories\Department\DepartmentInterface;

class DepartmentRepository implements DepartmentInterface
{

    use ReturnFormatTrait;
    protected $model;

    public function __construct(Department $model)
    {
        $this->model = $model;
    }

    public function all(string $orderBy = 'id', string $sortBy = 'desc')
    {

        return $this->model::orderBy($orderBy, $sortBy)->paginate(settings('paginate_value'));
    }

    public function activeDepartments()
    {
        return $this->model::where('status', Status::ACTIVE)->orderBy('title')->get();
    }

    public function get($id)
    {
        return $this->model::find($id);
    }

    public function store($request)
    {
        try {
            $department          = new Department();
            $department->title   = $request->title;
            $department->status  = $request->status;
            $department->save();

            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($request)
    {
        try {
            $department          = $this->model::find($request->id);
            $department->title   = $request->title;
            $department->status  = $request->status;
            $department->save();

            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function delete($id)
    {

        $this->model::destroy($id);
        return $this->responseWithSuccess(___('alert.successfully_Deleted'), []);
    }
}

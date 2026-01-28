<?php

namespace App\Repositories\Designation;

use App\Enums\Status;
use App\Models\Backend\Designation;
use App\Traits\ReturnFormatTrait;
use App\Repositories\Designation\DesignationInterface;

class DesignationRepository implements DesignationInterface
{
    use ReturnFormatTrait;
    protected $model;

    public function __construct(Designation $model)
    {
        $this->model = $model;
    }

    public function all(string $orderBy = 'id', string $sortBy = 'desc')
    {
        return $this->model::orderBy($orderBy, $sortBy)->paginate(settings('paginate_value'));
    }

    public function activeDesignations()
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
            $designation         = new Designation();
            $designation->title  = $request->title;
            $designation->status = $request->status;
            $designation->save();
            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($request)
    {
        try {
            $designation         = Designation::find($request->id);
            $designation->title  = $request->title;
            $designation->status = $request->status;
            $designation->save();
            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function delete($id)
    {
        // $this->model::destroy($id);
        $this->model::destroy($id);
        return $this->responseWithSuccess(___('alert.successfully_Deleted'), []);
    }
}

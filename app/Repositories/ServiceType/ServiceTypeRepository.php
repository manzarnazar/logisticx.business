<?php

namespace App\Repositories\ServiceType;

use App\Enums\Status;
use App\Traits\ReturnFormatTrait;
use App\Models\Backend\Charges\ServiceType;
use App\Repositories\Charge\ChargeInterface;
use App\Repositories\Coverage\CoverageInterface;

class ServiceTypeRepository implements ServiceTypeInterface
{
    use ReturnFormatTrait;
    private $model;
    private $coverageRepo;
    private $chargeRepo;

    public function __construct(ServiceType $model, CoverageInterface $coverageRepo, ChargeInterface $chargeRepo)
    {
        $this->model        = $model;
        $this->coverageRepo = $coverageRepo;
        $this->chargeRepo   = $chargeRepo;
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
        dd($request->all());
        try {
            $data           = $this->model;
            $data->name     = $request->name;
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
            $data->name     = $request->name;
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

    public function getServiseTypes($request)
    {
       $area = $this->coverageRepo->detectArea($request->pickup_id, $request->destination_id);

        $where = ['product_category_id' => $request->input('product_category_id'), 'area' => $area,  'status' => Status::ACTIVE];
        $serviceTypes  = $this->chargeRepo->getServiceType($where);


       return $serviceTypes;
    }
}

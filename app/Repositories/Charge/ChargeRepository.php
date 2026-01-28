<?php

namespace App\Repositories\Charge;

use App\Enums\Status;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\Cache;
use App\Models\Backend\Charges\Charge;

class ChargeRepository implements ChargeInterface
{
    use ReturnFormatTrait;
    private $model;


    public function __construct(Charge $model)
    {
        $this->model = $model;
    }

    public function all(?bool $status = null, array $column = [], ?int $paginate = null, string $orderBy = 'id', string $sortBy = 'desc')
    {
        $query = $this->model::query()
            ->when($status !== null, fn($q) => $q->where('status', $status))
            ->when(!empty($column), fn($q) => $q->select($column))
            ->orderBy($orderBy, $sortBy);

        return $paginate !== null ? $query->paginate($paginate) : $query->get();
    }


    public function get($id)
    {
        return  $this->model::findOrFail($id);
    }

    public function store($request)
    {
        try {
            $charge                         = $this->model;
            $charge->product_category_id    = $request->product_category_id;
            $charge->service_type_id        = $request->service_type_id;
            $charge->area                   = $request->area;
            $charge->delivery_time          = $request->delivery_time;
            $charge->charge                 = $request->charge;
            $charge->additional_charge      = $request->additional_charge != null ? $request->additional_charge : 0;
            $charge->delivery_commission                 = $request->delivery_commission;
            $charge->additional_delivery_commission      = $request->additional_delivery_commission != null ? $request->additional_delivery_commission : 0;
            $charge->return_charge          = $request->return_charge;
            $charge->position               = $request->position != null ? $request->position : 0;
            $charge->status                 = $request->status;
            $charge->save();

            Cache::deleteMultiple(['insideCityCharges', 'outsideCityCharges', 'subCityCharges', 'productCategories']);

            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($request)
    {
        try {
            $charge                         = $this->model::findOrFail($request->id);
            $charge->product_category_id    = $request->product_category_id;
            $charge->service_type_id        = $request->service_type_id;
            $charge->area                   = $request->area;
            $charge->delivery_time          = $request->delivery_time;
            $charge->charge                 = $request->charge;
            $charge->additional_charge      = $request->additional_charge != null ? $request->additional_charge : 0;
            $charge->delivery_commission                 = $request->delivery_commission;
            $charge->additional_delivery_commission      = $request->additional_delivery_commission != null ? $request->additional_delivery_commission : 0;
            $charge->return_charge          = $request->return_charge;
            $charge->position               = $request->position != null ? $request->position : 0;
            $charge->status                 = $request->status;
            $charge->save();

            Cache::deleteMultiple(['insideCityCharges', 'outsideCityCharges', 'subCityCharges', 'productCategories']);

            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function delete($id)
    {
        $this->model::destroy($id);

        Cache::deleteMultiple(['insideCityCharges', 'outsideCityCharges', 'subCityCharges', 'productCategories']);

        return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
    }

    public function getProductCategory(array $where = [])
    {
        return $this->model::with('productCategory:id,name')->where('status', Status::ACTIVE)->select('product_category_id')->distinct()->get();
    }


    public function getServiceType(array $where = [])
    {
        $query = $this->model::with('serviceType:id,name');

        if (!empty($where)) {
            $query->where($where);
        }

        $query->select('service_type_id');

        $query->distinct();

        return $query->get();
    }

    public function singleCharge(?int $id = null, array $where = ['status' => Status::ACTIVE], array $columns = ['id', 'delivery_time', 'charge', 'additional_charge'])
    {
        $query = $this->model::query();

        if ($id != null) {
            $query->where('id', $id);
        }

        if (!empty($where)) {
            $query->where($where);
        }

        return $query->first($columns);
    }

    public function getWithFilter(?string $with = null, $skipChargeIDs = [], array $where = [], array $columns = ['*'], $retrieveFirst = false)
    {
        $query = $this->model::query();

        if ($with != null) {
            $query->with($with);
        }

        if (!empty($skipChargeIDs)) {
            $query->whereNotIn('id', $skipChargeIDs);
        }

        $where['status'] = $where['status'] ?? Status::ACTIVE;
        $query->where($where);

        $query->select($columns);

        $query->distinct();

        if ($retrieveFirst) {
            return $query->first();
        }

        return $query->get();
    }

    public function getHeroCharge($charge_id, $parcel_quantity = 1)
    {
        $charge = Charge::findOrFail($charge_id);

        if (!$charge) {
            return 0;
        }

        $heroCharge = $charge->delivery_commission;

        if ($parcel_quantity > 1) {
            $heroCharge +=   ($parcel_quantity - 1) * $charge->additional_delivery_commission;
        }

        return $heroCharge;
    }
}

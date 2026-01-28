<?php

namespace App\Repositories\Merchant\DeliveryCharge;

use App\Enums\Status;
use App\Enums\UserType;
use App\Models\Backend\Merchant;
use App\Models\Backend\MerchantCharge;
use App\Models\Backend\MerchantSetting;
use App\Traits\ReturnFormatTrait;

class MerchantChargeRepository implements MerchantChargeInterface
{
    use ReturnFormatTrait;

    private $model;

    public function __construct(MerchantCharge $model)
    {
        $this->model = $model;
    }

    public function all(int $merchant_id = null, int $status = null, array $column = [], int $paginate = null, string $orderBy = 'position', array $where = [])
    {
        $query = $this->model::query();

        if ($merchant_id !== null || auth()->user()->user_type == UserType::MERCHANT) {
            $merchant_id = auth()->user()->user_type == UserType::MERCHANT ? auth()->user()->merchant->id : $merchant_id;
            $query->where('merchant_id', $merchant_id);
        }

        if (!empty($where)) {
            $query->where($where);
        }

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
            $charge                        = $this->model;
            $charge->merchant_id           = $request->merchant_id;
            $charge->charge_id             = $request->charge_id;
            $charge->product_category_id   = $request->product_category_id;
            $charge->service_type_id       = $request->service_type_id;
            $charge->area                  = $request->area;
            $charge->delivery_time         = $request->delivery_time;
            $charge->charge                = $request->charge;
            $charge->additional_charge     = $request->additional_charge;
            $charge->position              = $request->position != null ? $request->position : 0;
            $charge->status                = $request->status;
            $charge->save();

            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($request)
    {
        try {
            $charge                         = $this->get($request->id);
            $charge->delivery_time          = $request->delivery_time;
            $charge->charge                 = $request->charge;
            $charge->additional_charge      = $request->additional_charge;
            $charge->position               = $request->position != null ? $request->position : 0;
            $charge->status                 = $request->status;
            $charge->save();

            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function updateCodCharge($request, int $merchant_id)
    {
        try {

            $ignore   = [];
            $ignore[] = '_token';
            $ignore[] = '_method';

            foreach ($request->except($ignore) as $key => $value) {
                $settings        = MerchantSetting::where('key', $key)->where('merchant_id', $merchant_id)->first();

                if ($settings) {
                    $settings->value       = $value;
                    $settings->save();
                } else {
                    $settings              = new MerchantSetting();
                    $settings->key         = $key;
                    $settings->value       = $value;
                    $settings->merchant_id = $merchant_id;
                    $settings->save();
                }
            }

            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function delete(int $id)
    {
        try {
            $this->model::destroy($id);

            return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
        } catch (\Throwable $th) {

            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function singleCharge(int $charge_id = null, array $where = ['status' => Status::ACTIVE], array $columns = ['id', 'charge_id', 'delivery_time',  'charge', 'additional_charge'])
    {
        $query = $this->model::query();

        if ($charge_id !== null) {
            $query->where('charge_id', $charge_id);
        }

        if (!empty($where)) {
            $query->where($where);
        }

        return $query->first($columns);
    }
}

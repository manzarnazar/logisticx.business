<?php

namespace App\Repositories\MerchantPanel\PickupRequest;

use App\Enums\PickupRequestType;
use App\Models\PickupRequest;
use App\Repositories\MerchantPanel\PickupRequest\PickupRequestInterface;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\Auth;

class PickupRequestRepository implements PickupRequestInterface
{
    use ReturnFormatTrait;

    public function getRegular()
    {
        return PickupRequest::where('request_type', PickupRequestType::REGULAR)->orderByDesc('id')->paginate(15);
    }

    public function getExpress()
    {
        return PickupRequest::where('request_type', PickupRequestType::EXPRESS)->orderByDesc('id')->paginate(15);
    }

    public function regularStore($request)
    {
        try {

            $pickup_request                   = new PickupRequest();
            $pickup_request->request_type     = PickupRequestType::REGULAR;
            $pickup_request->merchant_id      = Auth::user()->merchant->id;
            $pickup_request->address          = $request->address ?: Auth::user()->merchant->address;
            $pickup_request->note             = $request->note;
            $pickup_request->parcel_quantity  = $request->parcel_quantity ?: null;
            $pickup_request->save();

            return $this->responseWithSuccess(___('alert.successfully_added'), ['status_code' => '201']);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), ['status_code' => '500']);
        }
    }
    public function expressStore($request)
    {
        try {

            $pickup_request                 = new PickupRequest();
            $pickup_request->request_type   = PickupRequestType::EXPRESS;
            $pickup_request->merchant_id    = Auth::user()->merchant->id;
            $pickup_request->address        = $request->address;
            $pickup_request->name           = $request->name;
            $pickup_request->phone          = $request->phone;
            $pickup_request->cod_amount     = $request->cod_amount;
            $pickup_request->invoice        = $request->invoice;
            $pickup_request->weight         = $request->weight;
            $pickup_request->exchange       = $request->has('exchange') ? 1 : 0;
            $pickup_request->note           = $request->note;
            $pickup_request->save();

            return $this->responseWithSuccess(___('alert.successfully_added'), ['status_code' => '201']);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), ['status_code' => '500']);
        }
    }

    public function getList($request)
    {
        $query = PickupRequest::query()
            ->where('merchant_id', auth()->user()->merchant->id)
            ->orderByDesc('id');

        if ($request->has('type')) {
            $query->where('request_type', $request->type);
        }

        return $query->paginate(15);
    }

    public function store($request)
    {
        try {
            $pickup_request = new PickupRequest();
            $pickup_request->merchant_id = auth()->user()->merchant->id;
            $pickup_request->request_type = $request->request_type; // REGULAR or EXPRESS
            $pickup_request->address = $request->address ?: auth()->user()->merchant->address;
            $pickup_request->note = $request->note;

            if ($request->request_type == \App\Enums\PickupRequestType::REGULAR) {
                $pickup_request->parcel_quantity = $request->parcel_quantity ?: null;
            } else {
                $pickup_request->name       = $request->name;
                $pickup_request->phone      = $request->phone;
                $pickup_request->cod_amount = $request->cod_amount;
                $pickup_request->invoice    = $request->invoice;
                $pickup_request->weight     = $request->weight;
                $pickup_request->exchange   = $request->has('exchange') ? 1 : 0;
            }

            $pickup_request->save();

            return $this->responseWithSuccess(___('alert.successfully_added'), ['status_code' => 201]);

        } catch (\Throwable $th) {
            return $this->responseWithError(__('alert.something_went_wrong'), ['status_code' => 500]);
        }
    }

    public function delete($id)
    {
        try {
            PickupRequest::destroy($id);

            return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

}

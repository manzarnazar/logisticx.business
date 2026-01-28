<?php

namespace App\Repositories\MerchantPanel\MerchantParcel;

use Carbon\Carbon;
use App\Enums\Status;
use App\Models\Subscribe;
use App\Enums\ParcelStatus;
use App\Models\MerchantShops;
use App\Models\Backend\Parcel;
use App\Models\Backend\Merchant;
use App\Models\Backend\ParcelEvent;
use Illuminate\Support\Facades\Auth;

class MerchantParcelRepository implements MerchantParcelInterface
{

    public function all($merchant_id, string $orderBy = 'id', string $sortBy = 'desc', $status = null, $paginate = true)
    {
        $status = strtoupper($status);

        $statusMap = [
            "PENDING"   => ParcelStatus::PENDING,
            "DELIVERED" => ParcelStatus::DELIVERED,
            "PARTIAL"   => ParcelStatus::PARTIAL_DELIVERED,
            "RETURN"    => ParcelStatus::RETURN_TO_COURIER,
        ];

        if (isset($statusMap[$status])) {
            return Parcel::where('merchant_id', $merchant_id)
                ->whereHas('parcelEvent', function ($q) use ($statusMap, $status) {
                    $q->latest()->where('parcel_status', $statusMap[$status]);
                })
                ->orderBy($orderBy, $sortBy)
                ->paginate(settings('paginate_value'));
        }

        return Parcel::where('merchant_id', $merchant_id)->orderBy($orderBy, $sortBy)->paginate(settings('paginate_value'));
    }

    public function parcelAll($merchant_id)
    {
        return Parcel::with('merchant')->where('merchant_id', $merchant_id)->orderByDesc('id')->get();
    }

    public function parcelBank($merchant_id, string $orderBy = 'id', string $sortBy = 'desc', $get = false)
    {
        $query = Parcel::query();
        $query->where('is_parcel_bank', 1);
        $query->where('merchant_id', $merchant_id);
        $query->orderBy($orderBy, $sortBy);
        if ($get) {
            return $query->get();
        }
        return $query->paginate(settings('paginate_value'));

        
    }

    public function filter($merchant_id, $request)
    {

        return Parcel::where('merchant_id', $merchant_id)->orderByDesc('id')->where(function ($query) use ($request) {

            if ($request->parcel_date) {
                if (strpos($request->parcel_date, ' to ') !== false) {
                    // Date with range has 'to '
                    $dateParts = explode(' to ', $request->parcel_date);
                    $from = Carbon::parse(trim($dateParts[0]))->startOfDay()->toDateTimeString();
                    $to   = Carbon::parse(trim($dateParts[1]))->endOfDay()->toDateTimeString();
                    $query->whereBetween('created_at', [$from, $to]);
                } else {
                    // Single date 
                    $singleDate = Carbon::parse(trim($request->parcel_date))->toDateString();
                    $query->whereDate('created_at', $singleDate);
                }
            }

            if ($request->parcel_status) {
                $query->where('status', $request->parcel_status);
            }

            if ($request->parcel_customer) {
                $query->where('customer_name', 'like', '%' . $request->parcel_customer . '%');
            }
            if ($request->parcel_customer_phone) {
                $query->where('customer_phone', 'like', '%' . $request->parcel_customer_phone . '%');
            }
            if ($request->invoice_id) {
                $query->where('invoice_no', 'like', '%' . $request->invoice_id . '%');
            }
        })->paginate(settings('paginate_value'));
    }

    public function parcelEvents($id)
    {
        return ParcelEvent::where('parcel_id', $id)->orderBy('created_at', 'desc')->get();
    }

    public function get($id)
    {
        return Parcel::find($id);
    }

    public function details($id)
    {
        return Parcel::where('id', $id)->where('merchant_id', auth()->user()->merchant->id)->with('parcelTransaction', 'merchant', 'parcelEvent')->firstOrFail();
    }

    public function getMerchant($id)
    {
        return Merchant::where('user_id', $id)->first();
    }

    public function getShop($merchantId)
    {
        return MerchantShops::where('merchant_id', $merchantId)->first();
    }

    public function getShops($merchantId)
    {
        return MerchantShops::where(['merchant_id' => $merchantId, 'status' => Status::ACTIVE])->get();
    }

    public function delete($id, $merchant_id)
    {
        return Parcel::destroy($id);
    }

    public function parcelTrack($track_id)
    {
        $parcel   = Parcel::where('tracking_id', $track_id)->with(['merchant'])->select('id', 'merchant_id', 'tracking_id', 'created_at')->first();
        $merchant = Merchant::find($parcel->merchant_id);
        $createdEvent = [
            'tracking_id'  => $parcel->tracking_id,
            'created_at'   => $parcel->created_at,
            'merchant_name' => $merchant->user->name,
            'email'        => $merchant->user->email,
            'mobile'       => $merchant->user->mobile
        ];
        if ($parcel) :
            $data = [
                'parcel' => $createdEvent,
                'events' => ParcelEvent::with(['deliveryMan', 'pickupman', 'transferDeliveryman', 'hub', 'user'])->where('parcel_id', $parcel->id)->orderBy('created_at', 'desc')->get()
            ];
            return $data;
        else :
            return false;
        endif;
    }


    public function subscribe($request)
    {

        try {
            $exists  = Subscribe::where('email', $request->email)->first();
            if ($exists) :
                return 1;
            else :
                try {
                    Subscribe::create(['email' => $request->email]);
                    return true;
                } catch (\Throwable $th) {
                    return false;
                }

            endif;
        } catch (\Throwable $th) {
            return false;
        }
    }

    public function filterExport($merchant_id, $request)
    {

        return Parcel::where('merchant_id', $merchant_id)->orderByDesc('id')->where(function ($query) use ($request) {

            if ($request->parcel_date) {
                $date = explode('to', $request->parcel_date);
                if (is_array($date)) {
                    $from   = Carbon::parse(trim($date[0]))->startOfDay()->toDateTimeString();
                    $to     = Carbon::parse(trim($date[1]))->endOfDay()->toDateTimeString();
                    $query->whereBetween('created_at', [$from, $to]);
                }
            }

            if ($request->parcel_status) {
                $query->where('status', $request->parcel_status);
            }
            if ($request->parcel_customer) {
                $query->where('customer_name', 'like', '%' . $request->parcel_customer . '%');
            }
            if ($request->parcel_customer_phone) {
                $query->where('customer_phone', 'like', '%' . $request->parcel_customer_phone . '%');
            }
        })->get();
    }

    public function parcelExport($request)
    {
        try {
            if ($request->parcel_date !== "" || $request->parcel_status !== "" || $request->parcel_customer !== "" || $request->parcel_customer_phone !== "") :
                $parcels  = $this->filterExport(Auth::user()->merchant->id, $request);
            else :
                $parcels = Parcel::where(['merchant_id' => Auth::user()->merchant->id])->get();
            endif;

            return $parcels;
        } catch (\Throwable $th) {

            return collect([]);
        }
    }
}

<?php

namespace App\Repositories\MerchantPanel\PaymentRequest;

use App\Enums\ApprovalStatus;
use App\Enums\UserType;
use App\Models\Backend\Payment;
use App\Models\MerchantPaymentPivot;
use App\Repositories\MerchantPanel\PaymentRequest\PaymentRequestInterface;
use App\Traits\ReturnFormatTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentRequestRepository implements PaymentRequestInterface
{
    use ReturnFormatTrait;


    protected $model;

    public function __construct(Payment $model)
    {
        $this->model        = $model;
    }


    public function get($id)
    {
        return   $this->model::with('merchantAccount')->where('id', $id)->first();
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            $payment                   = new Payment();
            $payment->merchant_id      = Auth::user()->merchant->id;
            $payment->amount           = $request->amount;
            $payment->merchant_account = $request->merchant_account;
            $payment->description      = $request->description;
            $payment->created_by       = UserType::MERCHANT;
            $payment->save();

            foreach ($request->parcel_id as $parcel_id) {
                $pivot              = new MerchantPaymentPivot();
                $pivot->payment_id  = $payment->id;
                $pivot->parcel_id   = $parcel_id;
                $pivot->save();
            }

            DB::commit();
            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($request)
    {
        try {
            DB::beginTransaction();
            $payment                   = $this->model::where('id', $request->id)->first();
            if ($payment->status == ApprovalStatus::PROCESSED) {
                return $this->responseWithError(__('This payment already processed.'), []);
            }
            $payment->merchant_id      = Auth::user()->merchant->id;
            $payment->amount           = $request->amount;
            $payment->merchant_account = $request->merchant_account;
            $payment->description      = $request->description;
            $payment->created_by       = UserType::MERCHANT;
            $payment->save();

            foreach ($request->parcel_id as $parcel_id) {
                $pivot              =  MerchantPaymentPivot::where('payment_id', $payment->id)->where('parcel_id', $parcel_id)->exists();
                if (!$pivot) {
                    $pivot              = new MerchantPaymentPivot();
                    $pivot->payment_id  = $payment->id;
                    $pivot->parcel_id   = $parcel_id;
                    $pivot->save();
                }
            }

            // delete old parcel ids
            MerchantPaymentPivot::where('payment_id', $payment->id)->whereNot('parcel_id', $request->parcel_id)->delete();

            DB::commit();
            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            DB::rollBack();
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function delete($id)
    {
        try {
            $payment = $this->model::find($id);

            if ($payment->status == ApprovalStatus::PROCESSED) {
                return $this->responseWithError(__('This payment already processed.'), []);
            }

            $payment->delete();

            return $this->responseWithSuccess(__('merchantmanage.delete_msg'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }
}

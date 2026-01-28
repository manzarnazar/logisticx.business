<?php

namespace App\Repositories\MerchantPayment;

use App\Enums\Merchant_panel\PaymentMethod;
use App\Enums\UserType;
use App\Models\MerchantPayment;
use App\Repositories\MerchantPayment\PaymentInterface;
use App\Traits\ReturnFormatTrait;

class PaymentRepository implements PaymentInterface
{

    use ReturnFormatTrait;

    protected $model;

    public function __construct(MerchantPayment $model)
    {
        $this->model = $model;
    }

    public function all($status = null, int $merchant_id = null, int $paginate = null, string $orderBy = 'id', string $sortBy = 'desc')
    {
        $query =   $this->model::query();

        if ($status !== null)  $query->where('status', $status);

        if ($merchant_id != null || auth()->user()->user_type == UserType::MERCHANT) {
            $merchant_id = auth()->user()->user_type == UserType::MERCHANT ?  auth()->user()->merchant->id : $merchant_id;
            $query->where('merchant_id', $merchant_id);
        }

        $query->orderBy($orderBy, $sortBy);

        return $paginate != null ? $query->paginate($paginate) : $query->get();
    }

    public function get($id)
    {
        return $this->model::findOrFail($id);
    }

    public function store($request)
    {
        try {
            $merchantPayment                    = new $this->model;
            $merchantPayment->merchant_id       = $request->merchant_id;
            $merchantPayment->payment_method    = $request->payment_method;

            if ($request->payment_method == PaymentMethod::bank || $request->payment_method == PaymentMethod::mfs) {
                $merchantPayment->account_name  = $request->account_name;
                $merchantPayment->mobile_no     = $request->mobile_no;
                $merchantPayment->account_type  = $request->input('bank_account_type') ?? $request->input('mfs_account_type');
            }

            if ($request->payment_method == PaymentMethod::bank) {
                $merchantPayment->bank_id       = $request->bank_id;
                $merchantPayment->branch_name   = $request->branch_name;
                $merchantPayment->routing_no    = $request->routing_no;
                $merchantPayment->account_no    = $request->account_no;
            }

            if ($request->payment_method == PaymentMethod::mfs) {
                $merchantPayment->mfs           = $request->mfs;
                $merchantPayment->account_no    = $request->mobile_no;
            }

            $merchantPayment->status            = $request->input('status');
            $merchantPayment->save();

            return $this->responseWithSuccess(___('alert.successfully_added'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function update($request)
    {
        \Log::info($request->all());
        try {

            $merchantAccount                    = $this->model::findOrFail($request->id);

            $merchantAccount->payment_method    = $request->payment_method;

            if ($request->payment_method == PaymentMethod::bank || $request->payment_method == PaymentMethod::mfs) {
                $merchantAccount->account_name  = $request->account_name;
                $merchantAccount->mobile_no     = $request->mobile_no;
                $merchantAccount->account_type  = $request->input('bank_account_type') ?? $request->input('mfs_account_type');
            }

            if ($request->payment_method == PaymentMethod::bank) {
                $merchantAccount->bank_id       = $request->bank_id;
                $merchantAccount->branch_name   = $request->branch_name;
                $merchantAccount->routing_no    = $request->routing_no;
                $merchantAccount->account_no    = $request->account_no;
            }

            if ($request->payment_method == PaymentMethod::mfs) {
                $merchantAccount->mfs           = $request->mfs;
                $merchantAccount->account_no    = $request->mobile_no;
            }

            $merchantAccount->status            = $request->input('status');
            $merchantAccount->save();

            return $this->responseWithSuccess(___('alert.successfully_updated'), []);
        } catch (\Throwable $th) {
            \Log::error($th);
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }

    public function delete($id)
    {
        try {
            $this->model::destroy($id);
            return $this->responseWithSuccess(___('alert.successfully_deleted'), []);
        } catch (\Throwable $th) {
            return $this->responseWithError(___('alert.something_went_wrong'), []);
        }
    }
}

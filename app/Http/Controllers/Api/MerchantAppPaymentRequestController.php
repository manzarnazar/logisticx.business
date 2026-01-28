<?php

namespace App\Http\Controllers\Api;

use App\Enums\UserType;
use App\Enums\ParcelStatus;
use Illuminate\Http\Request;
use App\Models\Backend\Parcel;
use App\Models\MerchantPayment;
use App\Enums\CashCollectionStatus;
use App\Http\Controllers\Controller;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Merchant\PaymentInfoStore;
use App\Http\Resources\Merchant\MerchantPaymentResource;
use App\Http\Requests\MerchantManage\Payment\StoreRequest;
use App\Http\Requests\MerchantPanel\PaymentRequest\StoreRequest as MerchantPaymentReqUpdate;
use App\Repositories\MerchantManage\Payment\PaymentInterface;
use App\Http\Resources\Merchant\MerchantPaymentRequestResource;
use App\Http\Resources\Merchant\MerchantParcelsForPaymentRequestResource;

class MerchantAppPaymentRequestController extends Controller
{
    use ApiReturnFormatTrait;

    protected $paymentRequestRepo;

    public function __construct(PaymentInterface $paymentRequestRepo)
    {
        $this->paymentRequestRepo = $paymentRequestRepo;
    }

    public function PaymentRequests()
    {
        $merchantId = Auth::user()->merchant->id;

        // paginate like parcels & accounts
        $requests = $this->paymentRequestRepo->all(
            merchant_id: $merchantId
        );

        // transform
        $data = [
            'requests' => MerchantPaymentRequestResource::collection($requests),
            'meta' => [
                'current_page' => $requests->currentPage(),
                'last_page'    => $requests->lastPage(),
                'per_page'     => $requests->perPage(),
                'total'        => $requests->total(),
            ]
        ];

        return $this->responseWithSuccess(__('alert.Payment Requests'), data: $data);
    }


    public function getParcelsForRequestPayment(Request $request)
    {

        $request_id = $request->query('requestId'); // fallback


        $mid = auth()->user()->merchant->id;

        $query = Parcel::query();
        $query->with('parcelTransaction:parcel_id,cash_collection,total_charge,current_payable');
        $query->where('merchant_id', $mid);
        $query->where(fn($q) =>
            $q->where('status', ParcelStatus::DELIVERED)
            ->orWhere('partial_delivered', true)
        );
        $query->where('cash_collection_status', CashCollectionStatus::RECEIVED_BY_ADMIN);

        if ($request_id) {
            // include already attached parcels too
            $query->where(function ($q) use ($request_id) {
                $q->doesntHave('merchantPaymentPivot')
                ->orWhereHas('merchantPaymentPivot', fn($q2) => $q2->where('payment_id', $request_id));
            });
        } else {
            $query->doesntHave('merchantPaymentPivot');
        }

        $parcels = $query->get(['id', 'merchant_id', 'delivery_date', 'tracking_id', 'status']);

        if ($parcels->isEmpty()) {
            return $this->responseWithError(___('alert.no_parcel_found'));
        }

        return $this->responseWithSuccess(
            data: MerchantParcelsForPaymentRequestResource::collection($parcels)
        );
    }


    // public function createPaymentRequest(Request $request)
    public function specificMerchantAccounts($merchant_id)
    {
        $accounts = MerchantPayment::where('merchant_id', $merchant_id)->get();
        if ($accounts) {
            $data = MerchantPaymentResource::collection($accounts);
            return $this->responseWithSuccess(data: $data);
        }
        return $this->responseWithError(___('alert.no_record_found'));
    }

    public function createPaymentRequest(StoreRequest $request)
    {
        $result = $this->paymentRequestRepo->store($request);

        if ($result['status']) {
            return $this->responseWithSuccess($result['message']);
        }
        return $this->responseWithError($result['message']);
    }

    public function view($id)
    {
        $request    = $this->paymentRequestRepo->get($id);

        if (!$request) {
            return $this->responseWithError(___('alert.no_record_found'));
        }
        $data = new MerchantPaymentRequestResource($request);
        return $this->responseWithSuccess(data: $data);
    }

    public function updatePaymentRequest(MerchantPaymentReqUpdate $request)
    {
        $result = $this->paymentRequestRepo->update($request);

        if ($result['status']) {
            return $this->responseWithSuccess($result['message']);
        }
        return $this->responseWithError($result['message']);
    }

    public function getPaymentRequestForEdit($id)
    {
        $request    = $this->paymentRequestRepo->get($id);
        if (!$request) {
            return $this->responseWithError(___('alert.no_record_found'));
        }
        $data = new MerchantPaymentRequestResource($request);
        return $this->responseWithSuccess(data: $data);
    }

    public function deletePaymentRequest($id)
    {
        $result = $this->paymentRequestRepo->delete($id);

        if ($result['status']) {
            return $this->responseWithSuccess($result['message']);
        }
        return $this->responseWithError($result['message']);
    }

}

<?php

namespace App\Http\Controllers\Api;

use App\Enums\CashCollectionStatus;
use App\Enums\ParcelStatus;
use App\Enums\PaymentStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Parcel\ParcelDeliveredRequest;
use App\Http\Resources\HeroCodPaymentResource;
use App\Http\Resources\HeroNotificationResource;
use App\Http\Resources\HeroParcelResource;
use App\Http\Resources\HeroPaymentsResource;
use App\Http\Resources\HeroSingleParcelResource;
use App\Models\Backend\ParcelStatusUpdate;
use App\Repositories\HeroApp\HeroAppInterface;
use App\Repositories\Parcel\ParcelInterface;
use App\Traits\ApiReturnFormatTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HeroAppController extends Controller
{
    use ApiReturnFormatTrait;

    protected $repo, $parcelRepo;

    private $statusSlug = [
        'pending'               => [ParcelStatus::PICKUP_ASSIGN, ParcelStatus::PICKUP_RE_SCHEDULE, ParcelStatus::DELIVERY_MAN_ASSIGN, ParcelStatus::DELIVERY_RE_SCHEDULE],
        'delivered'             => [ParcelStatus::DELIVERED],
        'partial-delivered'     => [ParcelStatus::PARTIAL_DELIVERED],
        'return'                => [ParcelStatus::RETURN_TO_COURIER],
    ];

    public function __construct(HeroAppInterface $repo, ParcelInterface $parcelRepo)
    {
        $this->repo         = $repo;
        $this->parcelRepo   = $parcelRepo;
    }

    public function parcels($status = null)
    {
        if ($status) {
            if (!array_key_exists($status, $this->statusSlug)) {
                return $this->responseWithError(___('alert.invalid_url'));
            }
            $status = $this->statusSlug[$status];
        }

        $parcels = $this->repo->parcels($status, paginate: settings('paginate_value'));

        if ($parcels->isEmpty()) {
            return $this->responseWithError(___('alert.no_parcel_found'));
        }

        $data = new HeroParcelResource($parcels);

        return $this->responseWithSuccess(data: $data);
    }

    public function singleParcel(Request $request)
    {
        $data = Validator::make($request->all(),  [
            'id'            => 'required_without:tracking_id|exists:parcels,id',
            'tracking_id'   => 'required_without:id|exists:parcels,tracking_id',
        ]);

        if ($data->fails()) {
            return $this->responseWithError(___('alert.validation_error'), $data->errors());
        }

        $parcel = $this->repo->singleParcel($request->id, $request->tracking_id);

        if ($parcel == null) {
            return $this->responseWithError(___('alert.no_parcel_found'));
        }

        dd('cvsdv');

        $parcel = new MerchantSingleParcelResource($parcel);

        return $this->responseWithSuccess(data: $parcel);
    }

    public function dashboardData()
    {
        return $this->responseWithSuccess(data: $this->repo->dashboardData());
    }

    public function heroPayments($payment_status = null)
    {
        if ($payment_status != null) {
            $status = ['paid' => PaymentStatus::PAID, 'unpaid' => PaymentStatus::UNPAID];

            if (!array_key_exists($payment_status, $status)) {
                return $this->responseWithError(___('alert.invalid_url'));
            }

            $payment_status = $status[$payment_status];
        }

        $commissions = $this->repo->heroPayments($payment_status, paginate: settings('paginate_value'));

        if ($commissions->isEmpty()) {
            return $this->responseWithError(___('alert.no_commission_found'));
        }

        $commissions = $commissions->map(fn ($commission) => new HeroPaymentsResource($commission));
        $commissions = $commissions->map(fn ($commission) => new HeroPaymentsResource($commission));

        return $this->responseWithSuccess(data: $commissions);
    }

    public function notifications()
    {
        $notifications = auth()->user()->notifications()->latest()->paginate(settings('paginate_value'));

        $data = HeroNotificationResource::collection($notifications);

        return $this->responseWithSuccess(data: $data);
    }

    private $statusForUpdate = [
        'delivered'             => ParcelStatus::DELIVERED,
        'partial-delivered'     => ParcelStatus::PARTIAL_DELIVERED,
        // 'return'                => ParcelStatus::RETURN_TO_COURIER,
    ];

    public function requestParcelDelivery(Request $request)
    {
        $data = Validator::make($request->all(), [
            'parcel_id' => 'required|exists:parcels,id',
            'status'    => 'required|in:' . implode(',', array_keys($this->statusForUpdate)),
        ]);

        if ($data->fails()) {
            return $this->responseWithError(___('alert.validation_error'), $data->errors());
        }

        $request->merge(['status' => $this->statusForUpdate[$request->status]]);

        $result = $this->repo->requestParcelDelivery($request);

        if ($result['status']) {
            return $this->responseWithSuccess($result['message'],);
        }

        return $this->responseWithError($result['message']);
    }

    public function ConfirmParcelDelivery(ParcelDeliveredRequest $request)
    {
        $event = ParcelStatusUpdate::where('parcel_id', $request->parcel_id)->where('otp',  $request->otp)->first();

        if (!$event) {
            return $this->responseWithError(___('alert.invalid_otp'));
        }

        if ($event->parcel_status == ParcelStatus::DELIVERED) {
            $result = $this->parcelRepo->parcelDelivered($request);
        }

        if ($event->parcel_status == ParcelStatus::PARTIAL_DELIVERED) {
            $result = $this->parcelRepo->parcelPartialDelivered($request);
        }

        if ($result['status']) {
            return $this->responseWithSuccess($result['message'],);
        }
        return $this->responseWithError($result['message']);
    }


    // codCollections
    public function codCollections()
    {
        request()->validate(['is_paid' => 'sometimes|boolean', 'page' => 'sometimes|numeric']);

        $parcels = $this->parcelRepo->codCollections(settings('paginate_value'), paidByHero: request('is_paid'));

        if ($parcels->isEmpty()) {
            return $this->responseWithError(message: ___('alert.No Parcels found'));
        }

        $data = $parcels->map(fn ($parcel) => new HeroCodPaymentResource($parcel));

        return $this->responseWithSuccess(message: ___('alert.COD Parcels list'), data: $data);
    }
}

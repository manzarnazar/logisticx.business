<?php

namespace App\Repositories\HeroApp;

use Carbon\Carbon;
use App\Enums\Status;
use App\Enums\ParcelStatus;
use App\Enums\PaymentStatus;
use App\Enums\SmsSendStatus;
use App\Models\Backend\Parcel;
use App\Http\Services\SmsService;
use App\Traits\ReturnFormatTrait;
use App\Enums\CashCollectionStatus;
use App\Models\Backend\ParcelEvent;
use App\Models\Backend\ParcelStatusUpdate;
use App\Models\Backend\DeliveryHeroCommission;

class HeroAppRepository implements HeroAppInterface
{
    use ReturnFormatTrait;

    protected $parcelModel;

    public function __construct(Parcel $parcelModel)
    {
        $this->parcelModel = $parcelModel;
    }

    public function parcels(array $status = null, int $paginate = null)
    {
        $hero_id = auth()->user()->deliveryman->id;

        $query = Parcel::query();

        if ($status) {
            $query->whereIn('status', $status);
        }

        $query->with('parcelTransaction:id,parcel_id,cash_collection');

        $query->whereHas('parcelEvent', fn ($query) => $query->where('delivery_man_id', $hero_id)->orWhere('pickup_man_id', $hero_id));

        $query->orderBy('updated_at', 'desc');

        // $query->select(['id', 'tracking_id', 'pickup_date', 'delivery_date', 'status', 'created_at', 'updated_at']);

        $parcels = $paginate != null ? $query->paginate($paginate) : $query->get();

        return $parcels;
    }

    public function singleParcel(int $id = null, string $tracking_id = null)
    {
        $hero_id = auth()->user()->deliveryman->id;

        $query = Parcel::query();
        $query->with('parcelTransaction:id,parcel_id,cash_collection', 'productCategory', 'serviceType',);
        $query->where(fn ($query) => $query->where('id', $id)->orWhere('tracking_id', $tracking_id));
        $query->whereHas('parcelEvent', fn ($query) => $query->where('delivery_man_id', $hero_id)->orWhere('pickup_man_id', $hero_id));
        $parcel =  $query->first();

        return $parcel;
    }

    public function dashboardData(): array
    {
        $hero_id        = auth()->user()->deliveryman->id;
        $startOfMonth   = Carbon::now()->startOfMonth();
        $endOfMonth     = Carbon::now()->endOfMonth();

        $query = Parcel::query();
        // $query->whereBetween('updated_at', [$startOfMonth, $endOfMonth]);
        $query->with('parcelTransaction:id,parcel_id,cash_collection');
        $query->whereHas('parcelEvent', fn ($query) => $query->where('delivery_man_id', $hero_id)->orWhere('pickup_man_id', $hero_id));
        $query->orderBy('updated_at', 'desc');
        $parcels =  $query->get();

        $commissions            = DeliveryHeroCommission::where('status', Status::ACTIVE)->where(fn ($comm) => $comm->where('delivery_hero_id', $hero_id)->orWhere('pickup_hero_id', $hero_id))->get();
        $commissionsThisMonth   = $commissions->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
        $deliveredParcels       = $parcels->whereIn('status', [ParcelStatus::DELIVERED, ParcelStatus::PARTIAL_DELIVERED]);

        $data = [
            'user_id'                   => auth()->user()->id,
            'hero_id'                   => $hero_id,

            'pending_parcel'            => $parcels->whereIn('status', [ParcelStatus::PICKUP_ASSIGN, ParcelStatus::PICKUP_RE_SCHEDULE, ParcelStatus::DELIVERY_MAN_ASSIGN, ParcelStatus::DELIVERY_RE_SCHEDULE])->count(),
            'delivered_parcel'          => $parcels->where('status', ParcelStatus::DELIVERED)->count(),
            'partial_delivered_parcel'  => $parcels->where('status', ParcelStatus::PARTIAL_DELIVERED)->count(),
            'returned_parcels'          => $parcels->where('status', ParcelStatus::RETURN_RECEIVED_BY_MERCHANT)->count(),

            'cash_collection'           => $deliveredParcels->sum(fn ($parcel) => $parcel->parcelTransaction->cash_collection ?? 0),
            'payable_to_hub'            => $deliveredParcels->where('cash_collection_status', CashCollectionStatus::PENDING->value)->sum(fn ($parcel) => $parcel->parcelTransaction->cash_collection ?? 0),
            'paid_to_hub'               => $deliveredParcels->where('cash_collection_status', '!=', CashCollectionStatus::PENDING->value)->sum(fn ($parcel) => $parcel->parcelTransaction->cash_collection ?? 0),

            'total_commission'          => $commissions->sum('amount'),
            'total_paid_commission'     => $commissions->where('payment_status', PaymentStatus::PAID)->sum('amount'),
            'total_unpaid_commission'   => $commissions->where('payment_status', PaymentStatus::UNPAID)->sum('amount'),
            'earning_this_month'        => $commissionsThisMonth->where('payment_status', PaymentStatus::PAID)->sum('amount'),
        ];

        return $data;
    }


    public function heroPayments($payment_status = null, int $paginate = null)
    {
        $hero_id        = auth()->user()->deliveryman->id;

        $commissions    = DeliveryHeroCommission::query();
        $commissions->where('status', Status::ACTIVE);
        if ($payment_status != null) {
            $commissions->where('payment_status', $payment_status);
        }
        $commissions->where(fn ($comm) => $comm->where('delivery_hero_id', $hero_id)->orWhere('pickup_hero_id', $hero_id));

        if ($paginate != null) {
            $commissions = $commissions->paginate($paginate);
        } else {
            $commissions = $commissions->get();
        }

        return   $commissions;
    }


    public function requestParcelDelivery($request)
    {
        try {
            $hero_id = auth()->user()->deliveryman->id;

            $event = ParcelEvent::where('parcel_id', $request->parcel_id)->where('delivery_man_id', $hero_id)->first();

            if (!$event) {
                return $this->responseWithError(___('alert.unauthorized'));
            }

            $parcelStatusUpdate                 = new ParcelStatusUpdate();
            $parcelStatusUpdate->parcel_id      = $request->parcel_id;
            $parcelStatusUpdate->parcel_status  = $request->status;
            $parcelStatusUpdate->otp            = config('app.app_demo') ? 123456 : random_int(100000, 999999);;
            $parcelStatusUpdate->save();

            app(SmsService::class)->sendOtp($event->parcel->customer_phone, $parcelStatusUpdate->otp);

            return $this->responseWithSuccess(___('alert.otp_send_to_customer'));
        } catch (\Exception $e) {
            return $this->responseWithError(___('alert.something_went_wrong'));
        }
    }
}

<?php

namespace App\Http\Resources;

use App\Enums\CashCollectionStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HeroCodPaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'parcel_id'                 => $this->id,
            'tracking_id'               => $this->tracking_id,
            'tracking_id'               => $this->tracking_id,
            'delivery_date'             => dateFormat($this->delivery_date),
            'customer_name'             => $this->customer_name,
            'customer_phone'            => $this->customer_phone,
            'customer_address'          => $this->customer_address,
            'cash_collection'           => $this->parcelTransaction?->cash_collection,
            'cash_collection_status'    => $this->cash_collection_status == CashCollectionStatus::PENDING->value ? ___('label.unpaid') : ___('label.paid'),
            'parcel_status'             => ___('parcel.' . config('site.status.parcel.' . $this->status)),
        ];
    }
}

<?php

namespace App\Http\Resources;

use App\Enums\ParcelStatus;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HeroSingleParcelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $parcel = [
            'id'                => $this->id,
            'tracking_id'       => $this->tracking_id,
            'product_category'  => $this->productCategory->name,
            'service_type'      => $this->serviceType->name,
            'quantity'          => $this->quantity,
            'invoice_no'        => $this->invoice_no,
            'hub'               => $this->hub->name,
            'vas'               => $this->vas_names,

            'status'            =>  $this->status,
            'status_text'       => ___('parcel.' . config('site.status.parcel.' . $this->status)),

            'pickup'            => [
                'merchant'      =>  $this->merchant->business_name,
                'shop'          =>  $this->shop->name,
                'phone'         =>  $this->pickup_phone,
                'address'       =>  $this->pickup_address,
                'pickup_date'   =>  $this->pickup_date,
            ],

            'delivery'          => [
                'customer_name'     => $this->customer_name,
                'customer_phone'    => $this->customer_phone,
                'customer_address'  => $this->customer_address,
                'cash_collection'   => $this->parcel_transaction->cash_collection ?? 0,
                'delivery_date'     => $this->delivery_date,
            ],

            'created_at'        => Carbon::parse($this->created_at)->toDateTimeString(),
            'updated_at'        => Carbon::parse($this->updated_at)->toDateTimeString(),
        ];

        return $parcel;
    }
}

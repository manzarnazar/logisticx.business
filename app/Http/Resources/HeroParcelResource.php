<?php

namespace App\Http\Resources;

use App\Enums\ParcelStatus;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class HeroParcelResource extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'parcels' => $this->collection->map(function ($parcel) {

                $data = [
                    'id'              => $parcel->id,
                    'tracking_id'     => $parcel->tracking_id,
                    'invoice_no'      => $parcel->invoice_no,
                    'status'          => $parcel->status,
                    'status_text'     => ___('parcel.' . config('site.status.parcel.' . $parcel->status)),

                    'pickup'            => [
                        'merchant'      =>  $parcel->merchant->business_name,
                        'shop'          =>  $parcel->shop->name,
                        'phone'         =>  $parcel->pickup_phone,
                        'address'       =>  $parcel->pickup_address,
                        'pickup_date'   =>  $parcel->pickup_date,
                    ],

                    'delivery'          => [
                        'customer_name'     => $parcel->customer_name,
                        'customer_phone'    => $parcel->customer_phone,
                        'customer_address'  => $parcel->customer_address,
                        'cash_collection'   => $parcel->parcel_transaction->cash_collection ?? 0,
                        'delivery_date'     => $parcel->delivery_date,
                    ],

                    'created_at'      => $parcel->created_at->toDateTimeString(),
                    'updated_at'      => $parcel->updated_at->toDateTimeString(),

                ];

                return $data;
            })
        ];
    }
}

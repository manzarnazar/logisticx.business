<?php

namespace App\Http\Resources\Merchant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantSingleParcelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'tracking_id'       => $this->tracking_id,
            'status'            => $this->status,
            'status_text'            => ___("parcel.".config("site.status.parcel.".$this->status)),
            'merchant_id'       => $this->merchant_id,
            'shop_id'           => $this->merchant_shop_id,
            'shop_name'           => $this->shop->name ?? null,
            'pickup_phone'      => $this->pickup_phone,
            'pickup_address'    => $this->pickup_address,
            'destination'       => $this->destination,
            'invoice_no'        => $this->invoice_no,

            'customer_name'     => $this->customer_name,
            'customer_phone'    => $this->customer_phone,
            'customer_address'  => $this->customer_address,
            'note'              => $this->note,

            'quantity'          => $this->quantity,
            'product_category'  => $this->product_category_id,
            'service_type'      => $this->service_type_id,
            'vas'               => $this->vas, // already saved as array
            'charge'            => $this->parcelTransaction->total_charge ?? 0,
            'cash_collection'   => $this->parcelTransaction->cash_collection ?? 0,
            'selling_price'     => $this->parcelTransaction->selling_price ?? 0,
            'payable'           => $this->parcelTransaction->current_payable ?? 0,

            'currency_charge'            => settings('currency') . ' ' .$this->parcelTransaction->total_charge ?? 0,
            'currency_cash_collection'   => settings('currency') . ' ' .$this->parcelTransaction->cash_collection ?? 0,
            'currency_selling_price'     => settings('currency') . ' ' .$this->parcelTransaction->selling_price ?? 0,
            'currency_payable'           => settings('currency') . ' ' .$this->parcelTransaction->current_payable ?? 0,

            'coupon'            => $this->coupon,
            'is_parcel_bank'    => $this->is_parcel_bank,
            'fragileLiquid'     => $this->fragileLiquid ?? null,

            'created_at'        => dateTimeFormat($this->created_at),
            'updated_at'        => dateTimeFormat($this->updated_at),

            'pickup_date'          => dateFormat($this->pickup_date),
            'delivery_date'        => dateFormat($this->delivery_date),
        ];
    }
}

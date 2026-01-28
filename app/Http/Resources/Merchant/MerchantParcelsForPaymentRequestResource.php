<?php

namespace App\Http\Resources\Merchant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantParcelsForPaymentRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'merchant_id'   => $this->merchant_id,
            'delivery_date' => $this->delivery_date,
            'tracking_id'   => $this->tracking_id,
            'current_payable'   => $this->parcelTransaction->current_payable,
            'status'        => $this->status,
        ];
    }
}

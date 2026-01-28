<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantChargeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'                  => $this->id,
            'merchant_id'         => $this->whenNotNull((int) $this->merchant_id, (int) $this->merchant_id), // Only include if it exists
            'charge_id'           => (int) $this->charge_id,
            'product_category'    => $this->productCategory->name,
            'service_type_id'     => $this->serviceType->name,
            'area'                => ___("charges.".$this->area),
            'delivery_time'       => $this->delivery_time,
            'charge'              => settings('currency') .' ' .$this->charge,
            'additional_charge'   => settings('currency') .' ' .$this->additional_charge,
            'position'            => (int) $this->position,
            'status'              => (int) $this->status,
        ];
    }
}

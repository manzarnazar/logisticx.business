<?php

namespace App\Http\Resources\Merchant;

use Illuminate\Http\Resources\Json\JsonResource;

class PickupRequestResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'             => $this->id,
            'request_type'   => $this->request_type,
            'address'        => $this->address,
            'note'           => $this->note,
            'parcel_quantity'=> (int) $this->parcel_quantity,
            'name'           => $this->name,
            'phone'          => $this->phone,
            'cod_amount'     => settings('currency') . ' ' .$this->cod_amount,
            'invoice'        => $this->invoice,
            'weight'         => (int) $this->weight,
            'exchange'       => (int) $this->exchange,
            'status'         => $this->status,
            'created_at'     => $this->created_at->toDateTimeString(),
        ];
    }
}

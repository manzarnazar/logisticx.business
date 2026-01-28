<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ParcelEventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'parcel_status'  => $this->parcel_status,
            'status_label'   => ___("parcel.".config('site.status.parcel.' . $this->parcel_status)),

            'note'           => $this->note,
            'hub'            => $this->hub?->name,
            'delivery_man'   => $this->deliveryMan?->name,
            'pickup_man'     => $this->pickupMan?->name,
            'transfer_man'   => $this->transferDeliveryMan?->name,
            'created_by'     => $this->createdBy?->name,

            'created_at'     => dateTimeFormat($this->created_at),
            'time_ago'       => $this->created_at?->diffForHumans(),
        ];
    }
}

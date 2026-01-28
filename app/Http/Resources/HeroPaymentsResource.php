<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HeroPaymentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'date'                  => Carbon::parse($this->updated_at)->toDateString(),
            'parcel_tracking_id'    => $this->parcel->tracking_id,
            'amount'                => $this->amount,
            'payment_status'        => ___('label.' . config('site.status.payment_status.' . $this->payment_status)),
        ];
    }
}

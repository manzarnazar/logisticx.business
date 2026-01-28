<?php

namespace App\Http\Resources\Merchant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantParcelStatusReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'status' => strip_tags(StatusParcel($this->first()->status)),
            'count'  => $this->count(),
        ];
    }
}

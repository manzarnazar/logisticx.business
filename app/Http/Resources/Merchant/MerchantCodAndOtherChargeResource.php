<?php

namespace App\Http\Resources\Merchant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantCodAndOtherChargeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'inside_city'    => settings('cod_inside_city'),
            'sub_city'       => settings('cod_sub_city'),
            'outside_city'   => settings('cod_outside_city'),
            'liquid_fragile' => settings('liquid_fragile'),
            'merchant_vat'   => settings('merchant_vat'),
        ];
    }
}

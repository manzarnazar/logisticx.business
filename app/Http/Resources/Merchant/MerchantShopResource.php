<?php

namespace App\Http\Resources\Merchant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantShopResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'         => $this->id,
            'merchant'   => $this->merchant->user->name,
            'name'       => $this->name,
            'contact_no' => $this->contact_no,
            'address'    => $this->address,
            'hub'    => $this->hub->id,
            'status'            => (int) $this->status,
            'default_shop'            => (int) $this->default_shop,
        ];
    }
}

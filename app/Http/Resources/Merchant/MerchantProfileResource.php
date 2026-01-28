<?php

namespace App\Http\Resources\Merchant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id'           => $this->id,
            'name'              => $this->name,
            'email'             => $this->email,
            'mobile'            => $this->mobile,
            'address'           => $this->address,
            'profile_photo_url' => getImage($this->upload),
            'merchant_id'       => $this->merchant->id,
            'merchant_name'     => $this->merchant->business_name,
            'status'            => $this->email_verified_at == null ? ___('label.unverified') : $this->status
        ];
    }
}

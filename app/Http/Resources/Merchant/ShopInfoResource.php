<?php

namespace App\Http\Resources\Merchant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShopInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'contact_no' => $this->contact_no,
            'address'    => $this->address
        ];
    }
}

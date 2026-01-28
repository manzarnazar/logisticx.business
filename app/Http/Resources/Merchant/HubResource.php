<?php

namespace App\Http\Resources\Merchant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HubResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'              => $this->id,
            'name'            => $this->name,
            'address'         => $this->address,
            'coverage'        => $this->coverage->name,
            // 'current_balance' => $this->current_balance,
        ];
    }
}

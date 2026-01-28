<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HeroProfileResource extends JsonResource
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
            'address'            => $this->address,
            'profile_photo_url' => asset($this->upload->original),
            'hero_id'           => $this->deliveryman->id,
        ];
    }
}

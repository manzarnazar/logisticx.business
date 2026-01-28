<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppSliderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'image_id' => getImage($this->upload, 'original','default-image-80x80.png'),
            'description' => $this->description,
            'status' => $this->status,
            'position' => $this->position
        ];
    }
}

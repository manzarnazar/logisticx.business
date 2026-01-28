<?php

namespace App\Http\Resources\Merchant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CoverageAreaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id ?? null, // Use null coalescing to avoid null errors
            'parent_id'    => $this->parent_id ?? null,
            'name'         => $this->name ?? null,
            'active_child' => CoverageAreaResource::collection($this->whenLoaded('activeChild')), // Recursive children
        ];
    }
}

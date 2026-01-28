<?php

namespace App\Http\Resources\Merchant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Merchant\ProductCategoryDetailsResource;

class ProductCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product_category_id' => $this->product_category_id,
            'product_category' => new ProductCategoryDetailsResource($this->whenLoaded('productCategory'))
        ];
    }
}

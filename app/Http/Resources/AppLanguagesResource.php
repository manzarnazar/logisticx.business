<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppLanguagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Extract last part from icon_class (e.g. "flag-icon-us" → "us")
        $iconClass = $this->icon_class ?? '';
        $parts = explode('-', $iconClass);
        $countryCode = end($parts); // get last word

        return [
            'id'             => $this->id,
            'name'           => $this->name,
            'code'           => $this->code,
            'flag'           => asset("backend/css/flag-icons/flags/" . $countryCode . ".svg"),
            'text_direction' => $this->text_direction,
            'status'         => (int) $this->status,
            // 'icon_class'   => $this->icon_class,
        ];
    }
}

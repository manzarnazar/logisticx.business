<?php

namespace App\Http\Resources\Merchant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupportChatResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'            => $this->id,
            'support_id'    => $this->support_id,
            'user_id'       => $this->user_id,
            'message'       => strip_tags($this->message), // Strips out HTML tags if you don't need them
            'attached_file' => $this->attached_file ? asset($this->attached_file) : null, // Generates the full URL for attached files
            'created_at'    => $this->created_at->format('Y-m-d H:i:s'), // Formats the creation timestamp
            'updated_at'    => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}

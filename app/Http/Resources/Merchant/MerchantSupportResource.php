<?php

namespace App\Http\Resources\Merchant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantSupportResource extends JsonResource
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
            'subject'    => $this->subject,
            'department' => $this->department->title,
            'department_id' => $this->department_id,
            'priority'   => $this->priority,
            'service'    => $this->service,
            'attached_file'       => asset(optional($this->file)->original),
            'date'       => $this->date,
            'user'       => $this->user->name,
            'description'       => $this->description,
            'chats'      => SupportChatResource::collection($this->whenLoaded('supportChats')),

        ];
    }
}

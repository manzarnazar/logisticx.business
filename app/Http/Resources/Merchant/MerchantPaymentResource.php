<?php

namespace App\Http\Resources\Merchant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Psy\Command\WhereamiCommand;

class MerchantPaymentResource extends JsonResource
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
            'merchant_id'   => (int) $this->merchant_id,
            'payment_method' => $this->payment_method,

            //Bank 
            'bank_id'       => $this->whenNotNull($this->bank_id, (int) $this->bank_id),
            'branch_name'   => $this->when($this->branch_name, $this->branch_name),
            'routing_no'    => $this->when($this->routing_no, $this->routing_no),
            'account_type'  => $this->when($this->account_type, $this->account_type),
            'account_no'    => $this->when($this->account_no, $this->account_no),

            // Conditionally include MFS-related fields only if they are not null
            'mfs'               => $this->when($this->mfs, $this->mfs),
            'mfs_account_type'  => $this->when($this->mfs_account_type, $this->mfs_account_type),

            'account_name'  => $this->account_name,
            'mobile_no'     => $this->mobile_no,
            'status'        => (int) $this->status,
        ];
    }
}

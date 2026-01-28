<?php

namespace App\Http\Resources\Merchant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantAccountTransactionReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'transaction_id' => $this->merchantPayment->transaction_id,
            'amount'         => settings('currency') .' ' .$this->amount,
            'type'           =>  $this->TransactionOppositeType,
            'date'           =>  $this->created_at,

        ];
    }
}

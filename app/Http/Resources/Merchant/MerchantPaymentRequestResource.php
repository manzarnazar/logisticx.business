<?php

namespace App\Http\Resources\Merchant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantPaymentRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'id'                  => $this->id,
            'merchant_id'         => (int) $this->merchant_id,
            'merchant_name'       => $this->merchant->user->namedsd,
            'amount'              => settings('currency') .' ' .$this->amount,
            'merchant_account'    => $this->merchant_account,
            'merchant_account_info'    => [
                    'payment_method' => $this->merchantAccount->payment_method,
                    'account_type'   => $this->merchantAccount->account_type,
                    'account_name'   => $this->merchantAccount->account_name,
            ]
                ,
            'bank_transaction_id' => $this->bank_transaction_id,
            'from_account'        => $this->from_account,
            'transaction_id'      => $this->transaction_id,
            'reference_file'      => asset($this->upload?->original),
            'description'         => $this->description,
            'created_at'          => dateFormat($this->created_at),
            'parcels' => $this->whenLoaded('parcelPivot', function () {
                return $this->parcelPivot->map(function ($pivot) {
                    return [
                        'id'           => $pivot->parcel->id,
                        'tracking_id'  => $pivot->parcel->tracking_id,
                        'current_payable' => $pivot->parcel->parcelTransaction->current_payable ?? 0,
                        'status_text'            => ___("parcel.".config("site.status.parcel.".$pivot->parcel->status)),
                    ];
                });
            }),
            'status'              => (int) $this->status,
            'status_text'              => ___("parcel.".config("site.status.approval.".$this->status)),
            
        ];
    }
}

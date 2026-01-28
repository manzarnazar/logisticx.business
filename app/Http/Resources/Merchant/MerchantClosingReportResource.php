<?php

namespace App\Http\Resources\Merchant;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantClosingReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'merchant_id'                   => $this->merchant_id,
            'business_name'                 => $this->business_name,
            'total_delivery_charge'         => settings('currency') .' ' .$this->totalDeliveryCharge,
            'total_cod_charge'              => settings('currency') .' ' .$this->totalCodCharge,
            'total_liquid_fragile_charge'   => settings('currency') .' ' .$this->totalLiquidFragileCharge,
            'total_vas_charge'              => settings('currency') .' ' .$this->totalVasCharge,
            'total_discount'                => settings('currency') .' ' .$this->totalDiscount,
            'total_vat'                     => settings('currency') .' ' .$this->totalVat,
            'total_charge'                  => settings('currency') .' ' .$this->totalCharge,
            'total_cash_collection'         => settings('currency') .' ' .$this->totalCashCollection,
            'total_cod_pending'             => settings('currency') .' ' .$this->totalCodPending,
            'total_cod_received_by_hub'     => settings('currency') .' ' .$this->totalCodReceivedByHub,
            'total_cod_received_by_admin'   => settings('currency') .' ' .$this->totalCodReceivedByAdmin,
            'total_cod_paid_to_merchant'    => settings('currency') .' ' .$this->totalCodPaidToMerchant,
            'total_paid_by_merchant'        => settings('currency') .' ' .$this->totalPaidByMerchant,
            'total_due_to_merchant'         => settings('currency') .' ' .$this->totalDueToMerchant,
            'total_payable_to_merchant'     => settings('currency') .' ' .$this->totalPayableToMerchant,
            'total_parcels'                 => $this->totalParcels,
            'charge_paid_parcels'           => $this->chargePaidParcels,
            'charge_not_paid_parcels'       => $this->chargeNotPaidParcels,
            'cod_pending_parcels'           => $this->codPendingParcels,
            'cod_received_by_hub_parcels'   => $this->codReceivedByHubParcels,
            'cod_received_by_admin_parcels' => $this->codReceivedByAdminParcels,
            'cod_paid_to_merchant_parcels'  => $this->codPaidToMerchantParcels,
            'parcel_status_counts'          => $this->parcelStatusCounts, // You might want to map this as well
        ];
    }
}

<?php

namespace Database\Seeders;

use App\Enums\UserType;
use App\Enums\ParcelStatus;
use App\Enums\ApprovalStatus;
use App\Models\Backend\Parcel;
use App\Models\Backend\Payment;
use App\Models\MerchantPayment;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Enums\CashCollectionStatus;
use App\Models\MerchantPaymentPivot;

class PaymentRequestSeeder extends Seeder
{
    public function run(): void
    {
        DB::beginTransaction();

        try {
            $merchantId = 1;

            // Get merchant's accounts
            $accounts = MerchantPayment::where('merchant_id', $merchantId)->pluck('id')->toArray();
            if (empty($accounts)) {
                $this->command->warn("No payment accounts found for merchant_id {$merchantId}");
                return;
            }

            // Get eligible parcels
            $eligibleParcels = Parcel::with('parcelTransaction')
                ->where('merchant_id', $merchantId)
                ->where(fn($query) => $query->where('status', ParcelStatus::DELIVERED)->orWhere('partial_delivered', true))
                ->where('cash_collection_status', CashCollectionStatus::RECEIVED_BY_ADMIN)
                ->doesntHave('merchantPaymentPivot')
                ->get();


            if ($eligibleParcels->isEmpty()) {
                $this->command->warn("No eligible parcels found for merchant_id {$merchantId}");
                return;
            }

            // Split parcels into chunks for 5 payments
            $parcelChunks = $eligibleParcels->chunk( max(1, floor($eligibleParcels->count() / 2)) );

            $statuses = [
                ApprovalStatus::PENDING,
                ApprovalStatus::APPROVED,
                ApprovalStatus::PROCESSED,
                ApprovalStatus::REJECT,
            ];

            $count = 0;
            foreach ($parcelChunks as $chunk) {
                if ($count >= 5) break;

                $amount = 0;
                foreach ($chunk as $parcel) {
                    if ($parcel->parcelTransaction) {
                        $amount += $parcel->parcelTransaction->cash_collection - $parcel->parcelTransaction->total_charge;
                    }
                }

                if ($amount <= 0) continue;

                // Create Payment
                $payment = Payment::create([
                    'merchant_id'      => $merchantId,
                    'amount'           => $amount,
                    'merchant_account' => $accounts[array_rand($accounts)],
                    'description'      => "Seeder test payment " . ($count + 1),
                    'created_by'       => ($count % 2 === 0) ? UserType::MERCHANT : UserType::ADMIN,
                    'status'           => $statuses[$count],
                ]);

                // Attach parcels to pivot
                foreach ($chunk as $parcel) {
                    MerchantPaymentPivot::create([
                        'payment_id' => $payment->id,
                        'parcel_id'  => $parcel->id,
                    ]);
                }

                $count++;
            }

            DB::commit();
            $this->command->info("5 Payment records created with pivot parcels for merchant_id {$merchantId}");

        } catch (\Throwable $th) {
            DB::rollBack();
            $this->command->error("PaymentsTableSeeder failed: " . $th->getMessage());
        }
    }
}

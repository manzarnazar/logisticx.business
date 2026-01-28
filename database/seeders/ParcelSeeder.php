<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Backend\Parcel;
use App\Enums\ParcelStatus;
use App\Enums\Status;
use App\Enums\CashCollectionStatus;
use App\Models\Backend\Charges\Charge;
use App\Models\Backend\Charges\ValueAddedService;
use App\Models\Backend\Merchant;
use App\Models\Backend\ParcelEvent;
use App\Models\Backend\ParcelTransaction;
use App\Models\MerchantShops;
use Illuminate\Support\Str;

class ParcelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $charges    = Charge::where('status', Status::ACTIVE)->get();
        $allVas     = ValueAddedService::where('status', Status::ACTIVE)->get(['id', 'price']);
        $merchants  = Merchant::where('status', Status::ACTIVE)->get();

        if ($merchants->isEmpty() || $charges->isEmpty() || $allVas->isEmpty()) {
            return;
        }

        // 🔹 Seed at least 6 parcels for merchant_id = 1 (always delivered + received_by_admin)
        $merchant1 = $merchants->where('id', 1)->first();
        if ($merchant1 && $merchant1->shops->isNotEmpty()) {
            $this->seedMerchant1Parcels($merchant1, $charges, $allVas, 60);
        }

        // 🔹 Seed 5 parcels for each other merchant
        $otherMerchants = $merchants->where('id', '!=', 1);
        foreach ($otherMerchants as $merchant) {
            if ($merchant->shops->isNotEmpty()) {
                $this->seedGenericParcels($merchant, $charges, $allVas, 5);
            }
        }
    }

    /**
     * Always create delivered + received_by_admin parcels for merchant 1.
     */
    private function seedMerchant1Parcels($merchant, $charges, $allVas, $count = 20)
    {
        for ($i = 0; $i < $count; $i++) {
            $charge = $charges->random();
            $vas    = $allVas->random(rand(1, 2));
            $shop   = $merchant->shops->random();

            $parcel                      = new Parcel();
            $parcel->merchant_id         = $merchant->id;
            $parcel->merchant_shop_id    = $shop->id;
            $parcel->pickup_address      = $shop->address;
            $parcel->pickup_phone        = $shop->contact_no;
            $parcel->pickup              = $shop->coverage_id;
            $parcel->destination         = $shop->coverage_id;

            $parcel->customer_name       = fake()->name;
            $parcel->customer_phone      = fake()->phoneNumber();
            $parcel->customer_address    = fake()->address;
            $parcel->note                = fake()->sentence();
            $parcel->invoice_no          = strtoupper('INV1' . str_pad($i, 5, '0', STR_PAD_LEFT));

            $parcel->area                = $charge->area;
            $parcel->product_category_id = $charge->product_category_id;
            $parcel->service_type_id     = $charge->service_type_id;
            $parcel->charge_id           = $charge->id;

            $parcel->is_parcel_bank      = ($i % 2 == 0) ? 1 : 0;
            $parcel->vat                 = 10;
            $parcel->quantity            = rand(1, 3);
            $parcel->vas                 = $vas->toArray();

            // ✅ Fixed values for payment requests
            if ($i % 2 === 0) {
                // Even index → Delivered & Received by Admin
                $parcel->status                 = ParcelStatus::DELIVERED;
                $parcel->cash_collection_status = CashCollectionStatus::RECEIVED_BY_ADMIN;
            } else {
                // Odd index → Pending & Pending
                $parcel->status                 = ParcelStatus::PENDING;
                $parcel->cash_collection_status = CashCollectionStatus::PENDING;
            }

            $parcel->first_hub_id        = $shop->hub_id;
            $parcel->hub_id              = $shop->hub_id;

            $parcel->tracking_id         = Str::upper('M1' . base_convert(microtime(true), 10, 36) . $i . 'P');
            $parcel->save();

            $this->createTransactionAndEvent($parcel, $vas);
        }
    }

    /**
     * Create generic mixed parcels for other merchants.
     */
    private function seedGenericParcels($merchant, $charges, $allVas, $count = 5)
    {
        for ($i = 0; $i < $count; $i++) {
            $charge = $charges->random();
            $vas    = $allVas->random(rand(1, 2));
            $shop   = $merchant->shops->random();

            $parcel                      = new Parcel();
            $parcel->merchant_id         = $merchant->id;
            $parcel->merchant_shop_id    = $shop->id;
            $parcel->pickup_address      = $shop->address;
            $parcel->pickup_phone        = $shop->contact_no;
            $parcel->pickup              = $shop->coverage_id;
            $parcel->destination         = $shop->coverage_id;

            $parcel->customer_name       = fake()->name;
            $parcel->customer_phone      = fake()->phoneNumber();
            $parcel->customer_address    = fake()->address;
            $parcel->note                = fake()->sentence();
            $parcel->invoice_no          = strtoupper('INV' . $merchant->id . str_pad($i, 5, '0', STR_PAD_LEFT));

            $parcel->area                = $charge->area;
            $parcel->product_category_id = $charge->product_category_id;
            $parcel->service_type_id     = $charge->service_type_id;
            $parcel->charge_id           = $charge->id;

            $parcel->is_parcel_bank      = ($i % 2 == 0) ? 1 : 0;
            $parcel->vat                 = 10;
            $parcel->quantity            = rand(1, 3);
            $parcel->vas                 = $vas->toArray();

            // Mixed statuses
            $parcel->status = ($i % 3 === 0) ? ParcelStatus::DELIVERED : ParcelStatus::PENDING;

            // Mixed cash collection statuses
            $parcel->cash_collection_status = match (true) {
                $i % 5 === 0 => CashCollectionStatus::RECEIVED_BY_ADMIN,
                $i % 2 === 0 => CashCollectionStatus::RECEIVED_BY_HUB,
                default      => CashCollectionStatus::PENDING,
            };

            $parcel->first_hub_id        = $shop->hub_id;
            $parcel->hub_id              = $shop->hub_id;

            $parcel->tracking_id         = Str::upper('M' . $merchant->id . base_convert(microtime(true), 10, 36) . $i . 'P');
            $parcel->save();

            $this->createTransactionAndEvent($parcel, $vas);
        }
    }

    /**
     * Shared method for transactions & events.
     */
    private function createTransactionAndEvent($parcel, $vas)
    {
        // Transaction
        $transaction                        = new ParcelTransaction();
        $transaction->parcel_id             = $parcel->id;
        $transaction->cash_collection       = rand(500, 2000);
        $transaction->selling_price         = $transaction->cash_collection - rand(100, 200);
        $transaction->charge                = rand(50, 60);
        $transaction->cod_charge            = rand(5, 10);
        $transaction->liquid_fragile_charge = rand(5, 10);
        $transaction->vas_charge            = $vas->sum('price');
        $transaction->discount              = rand(0, 20);
        $transaction->vat_amount            = rand(20, 30);
        $transaction->total_charge          = $transaction->charge + $transaction->cod_charge + $transaction->liquid_fragile_charge + $transaction->vas_charge - $transaction->discount + $transaction->vat_amount;
        $transaction->current_payable       = $transaction->cash_collection - $transaction->total_charge;
        $transaction->save();

        // Event
        $event                = new ParcelEvent();
        $event->parcel_id     = $parcel->id;
        $event->note          = 'Parcel Created';
        $event->parcel_status = $parcel->status;
        $event->created_by    = 1;
        $event->save();
    }
}

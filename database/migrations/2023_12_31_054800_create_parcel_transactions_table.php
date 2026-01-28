<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('parcel_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parcel_id')->constrained('parcels')->cascadeOnDelete();

            $table->decimal('cash_collection', 13, 2)->nullable()->default(0);
            $table->decimal('old_cash_collection', 13, 2)->nullable()->default(0);
            $table->decimal('selling_price', 13, 2)->nullable()->default(0);

            // parcel charges 
            $table->decimal('charge', 13, 2)->nullable()->default(0); // basic delivery charge
            $table->decimal('cod_charge', 13, 2)->nullable()->default(0);
            $table->decimal('liquid_fragile_charge', 13, 2)->nullable()->default(0);
            $table->decimal('vas_charge', 13, 2)->nullable()->default(0); // total value added service charge
            $table->decimal('discount', 13, 2)->nullable()->default(0);
            $table->decimal('vat_amount', 13, 2)->nullable()->default(0);
            $table->decimal('total_charge', 13, 2)->nullable()->default(0)->comment('( Charge + cod + liquid_fragile + vas - discount) + vat');

            $table->decimal('current_payable', 13, 2)->nullable()->default(0);

            $table->decimal('return_charges', 13, 2)->nullable()->default(0)->comment('received by merchant return charges');

            // $table->decimal('delivery_charge', 13, 2)->nullable();
            // $table->decimal('total_delivery_amount', 13, 2)->nullable();


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parcel_transactions');
    }
};

<?php

use App\Enums\CashCollectionStatus;
use App\Enums\ParcelPaymentStatus;
use App\Enums\ParcelStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('parcels', function (Blueprint $table) {
            $table->id();

            $table->foreignId('merchant_id')->constrained('merchants')->onDelete('cascade');
            $table->foreignId('merchant_shop_id')->nullable();

            $table->string('pickup_phone')->nullable();
            $table->longText('pickup_address')->nullable();

            $table->foreignId('pickup')->nullable()->comment('coverages id')->constrained('coverages')->nullOnDelete();
            $table->foreignId('destination')->nullable()->comment('coverages id')->constrained('coverages')->nullOnDelete();

            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->longText('customer_address')->nullable();
            $table->longText('note')->nullable();

            $table->string('invoice_no')->nullable();
            $table->longText('vas')->nullable()->comment('Value Added Service');

            $table->string('area')->nullable();
            $table->foreignId('product_category_id')->nullable()->constrained('product_categories')->nullOnDelete();
            $table->foreignId('service_type_id')->nullable()->constrained('service_types')->nullOnDelete();
            $table->foreignId('charge_id')->nullable()->constrained('charges')->nullOnDelete();   //global charge id

            $table->unsignedInteger('old_quantity')->default(0)->nullable();
            $table->unsignedInteger('quantity')->default(1)->nullable();

            $table->string('coupon')->nullable();

            $table->bigInteger('vat')->nullable()->comment('%'); //percentage

            $table->string('tracking_id')->nullable();

            $table->foreignId('first_hub_id')->nullable()->constrained('hubs'); //first hub id from hub
            $table->foreignId('hub_id')->nullable()->constrained('hubs'); //hub id from hub
            $table->foreignId('transfer_hub_id')->nullable()->constrained('hubs'); //hub id from hub

            $table->string('parcel_bank')->nullable();
            $table->date('pickup_date')->nullable();
            $table->date('delivery_date')->nullable();

            $table->unsignedTinyInteger('partial_delivered')->nullable()->comment('no=0, yes=1');

            $table->enum('cash_collection_status', [
                CashCollectionStatus::PENDING->value,
                CashCollectionStatus::RECEIVED_BY_HUB->value,
                CashCollectionStatus::RECEIVED_BY_ADMIN->value,
                CashCollectionStatus::PAID_TO_MERCHANT->value,
            ])->default(CashCollectionStatus::PENDING->value)->nullable();

            $table->boolean('is_charge_paid')->default(false)->comment('no=0, yes=1');
            $table->boolean('is_parcel_bank')->default(false)->comment('no=0, yes=1');

            $table->unsignedTinyInteger('status')->default(ParcelStatus::PENDING)->comment('Parcel Status');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parcels');
    }
};

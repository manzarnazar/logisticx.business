<?php

use App\Enums\PaymentStatus;
use App\Enums\Status;
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
        Schema::create('delivery_hero_commissions', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 16, 2)->comment('commission');
            $table->foreignId('parcel_id')->constrained('parcels')->cascadeOnDelete();
            $table->foreignId('delivery_hero_id')->nullable()->constrained('delivery_man')->cascadeOnDelete();
            $table->foreignId('pickup_hero_id')->nullable()->constrained('delivery_man')->cascadeOnDelete();
            $table->foreignId('expense_id')->nullable()->constrained('expenses')->cascadeOnDelete();
            $table->enum('payment_status', [PaymentStatus::PAID, PaymentStatus::UNPAID])->default(PaymentStatus::UNPAID)->comment(PaymentStatus::PAID . ' means paid,' .  PaymentStatus::UNPAID . ' unpaid');
            $table->boolean('status')->default(Status::ACTIVE)->comment(Status::INACTIVE . ' means delete');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_hero_commissions');
    }
};

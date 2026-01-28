<?php

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
        Schema::create('merchant_charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained('merchants', 'id')->cascadeOnDelete();
            $table->foreignId('charge_id')->constrained('charges', 'id')->cascadeOnDelete();
            $table->foreignId('product_category_id')->constrained('product_categories', 'id')->restrictOnDelete();
            $table->foreignId('service_type_id')->constrained('service_types', 'id')->restrictOnDelete();
            $table->string('area');
            $table->string('delivery_time');
            $table->decimal('charge', 16, 2);
            $table->decimal('additional_charge', 16, 2)->nullable()->comment('additional charge per quantity');
            $table->integer('position')->nullable()->default(0);
            $table->boolean('status')->default(Status::ACTIVE)->comment(Status::ACTIVE . ' = Active'  . ', ' . Status::INACTIVE . ' = Inactive');
            $table->timestamps();

            // combination unique_merchant_charges
            $table->unique(['merchant_id', 'product_category_id', 'service_type_id', 'area'], 'unique_merchant_charges');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchant_charges');
    }
};

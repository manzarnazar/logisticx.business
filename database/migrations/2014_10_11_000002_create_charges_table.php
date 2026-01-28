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
        Schema::create('charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_category_id')->constrained('product_categories', 'id')->restrictOnDelete();
            $table->foreignId('service_type_id')->constrained('service_types', 'id')->restrictOnDelete();
            $table->enum('area', config('site.areas'));
            $table->string('delivery_time')->comment('Hour');
            $table->decimal('charge', 16, 2)->comment('Per quantity');
            $table->decimal('additional_charge', 16, 2)->default(0)->nullable()->comment('Per quantity');
            $table->decimal('return_charge', 5, 2)->default(0)->nullable()->comment('Percentage (%) per quantity');
            $table->decimal('delivery_commission', 16, 2)->comment('Per quantity');
            $table->decimal('additional_delivery_commission', 16, 2)->default(0)->nullable()->comment('Per quantity');
            $table->integer('position')->nullable()->default(0);
            $table->boolean('status')->default(Status::ACTIVE)->comment(Status::ACTIVE . ' = Active'  . ', ' . Status::INACTIVE . ' = Inactive');
            $table->timestamps();

            $table->unique(['product_category_id', 'service_type_id', 'area',]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('charges');
    }
};

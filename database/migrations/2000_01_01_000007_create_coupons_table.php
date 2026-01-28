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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('coupon')->unique()->comment('Coupon Code');
            $table->tinyInteger('type')->comment('1=common, 2=merchant_wise');
            $table->json('mid')->comment('Merchant ID')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            $table->tinyInteger('discount_type')->comment('1=fixed, 2=percent');
            $table->integer('discount')->default(0);
            $table->boolean('status')->default(Status::ACTIVE)->comment(Status::ACTIVE . ' = Active'  . ', ' . Status::INACTIVE . ' = Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};

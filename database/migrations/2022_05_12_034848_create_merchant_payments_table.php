<?php

use App\Enums\Status;
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
        Schema::create('merchant_payments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('merchant_id')->nullable()->constrained('merchants')->onDelete('cascade');

            $table->string('payment_method')->nullable();

            //bank info
            $table->foreignId('bank_id')->nullable()->constrained('banks');
            $table->string('branch_name')->nullable();
            $table->string('routing_no')->nullable();

            //mobile info
            $table->string('mfs')->nullable()->comment('Mobile Financial Service');

            // account info 
            $table->string('account_type')->nullable();
            $table->string('account_name')->nullable();
            $table->string('account_no')->nullable();
            $table->string('mobile_no')->nullable();

            $table->boolean('status')->default(Status::ACTIVE)->comment(Status::ACTIVE . '= Active ,' . Status::INACTIVE . '= Inactive');
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
        Schema::dropIfExists('merchant_payments');
    }
};

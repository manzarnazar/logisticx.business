<?php

use App\Enums\Status;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('business_name');
            $table->string('merchant_unique_id')->nullable();


            $table->foreignId('nid_id')->nullable()->constrained('uploads')->onDelete('cascade');
            $table->foreignId('trade_license')->nullable()->constrained('uploads')->onDelete('cascade');


            $table->longText('address')->nullable();
            $table->foreignId('coverage_id')->nullable()->constrained('coverages')->nullOnDelete();
            $table->foreignId('pickup_slot_id')->nullable()->constrained('pickup_slots')->nullOnDelete();

            //new fields
            $table->decimal('return_charges', 16, 2)->default(100)->comment('100 = 100%  means full charge will received courier');
            $table->string('reference_name')->nullable();
            $table->string('reference_phone')->nullable();

            $table->unsignedTinyInteger('status')->default(Status::ACTIVE)->comment(Status::ACTIVE . '= Active, ' . Status::INACTIVE . '= Inactive');



            $table->timestamps();

            // update_merchants_table available
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merchants');
    }
};

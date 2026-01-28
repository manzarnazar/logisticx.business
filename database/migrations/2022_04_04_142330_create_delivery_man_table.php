<?php

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
        Schema::create('delivery_man', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('coverage_id')->nullable()->constrained('coverages')->nullOnDelete();
            $table->foreignId('pickup_slot_id')->nullable()->constrained('pickup_slots')->nullOnDelete();
            $table->foreignId('driving_license')->nullable()->comment('upload id')->constrained('uploads')->onDelete('cascade');
            $table->unsignedTinyInteger('status')->default(\App\Enums\Status::ACTIVE)->comment(\App\Enums\Status::ACTIVE . '=' . trans('status.' . \App\Enums\Status::ACTIVE) . ', ' . \App\Enums\Status::INACTIVE . '=' . trans('status.' . \App\Enums\Status::INACTIVE));
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
        Schema::dropIfExists('delivery_man');
    }
};

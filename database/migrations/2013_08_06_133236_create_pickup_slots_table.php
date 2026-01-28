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
        Schema::create('pickup_slots', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('position')->nullable()->default(0);
            $table->boolean('status')->default(Status::ACTIVE)->comment(Status::ACTIVE . ' = Active'  . ', ' . Status::INACTIVE . ' = Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pickup_slots');
    }
};

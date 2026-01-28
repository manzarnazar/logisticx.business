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
        Schema::create('coverages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('coverages')->cascadeOnDelete();
            $table->string('name')->comment('Area Name');
            $table->unsignedInteger('position')->nullable()->default(0);
            $table->boolean('status')->default(Status::ACTIVE)->comment(Status::ACTIVE . ' = Active'  . ', ' . Status::INACTIVE . ' = Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coverages');
    }
};

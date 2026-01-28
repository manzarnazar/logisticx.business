<?php

use App\Enums\Status;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('app_sliders', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('position')->nullable();
            $table->string('description')->nullable();
            $table->foreignId('image_id')->nullable()->constrained('uploads')->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('status')->default(Status::ACTIVE)->comment(Status::ACTIVE . '= Active ,' . Status::INACTIVE . '= Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('app_sliders');
    }
};

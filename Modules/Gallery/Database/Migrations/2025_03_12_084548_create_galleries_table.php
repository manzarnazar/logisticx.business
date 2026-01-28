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
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->Text('short_description')->nullable();
            $table->foreignId('image_id')->nullable()->comment('upload id')->constrained('uploads')->nullOnDelete();
            $table->unsignedBigInteger('status')->default(Status::ACTIVE)->comment(Status::ACTIVE . '= ' . __('status.' . Status::ACTIVE) . ',' . Status::INACTIVE . '= ' . __('status.' . Status::INACTIVE));
            $table->Integer('position')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galleries');
    }
};

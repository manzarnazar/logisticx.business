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
        Schema::create('home_page_sliders', function (Blueprint $table) {
            $table->id();
            $table->string('small_title')->nullable();
            $table->string('title')->nullable();
            $table->longText('description')->nullable();
            $table->string('page_link')->nullable();
            $table->string('video_link')->nullable();
            $table->string('position')->nullable();
            $table->bigInteger('banner')->nullable();
            $table->string('date')->nullable();
            $table->boolean('status')->default(Status::ACTIVE)->comment(Status::ACTIVE . '= Active ,' . Status::INACTIVE . '= Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_page_sliders');
    }
};

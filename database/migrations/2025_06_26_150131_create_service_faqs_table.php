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
        Schema::create('service_faqs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('position')->nullable();
            $table->string('service_id')->nullable();
            $table->string('description')->nullable();
            $table->boolean('status')->default(Status::ACTIVE)->comment(Status::ACTIVE . '= Active ,' . Status::INACTIVE . '= Inactive');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_faqs');
    }
};

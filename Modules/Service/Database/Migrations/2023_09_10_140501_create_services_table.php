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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('short_description')->nullable();
            $table->longText('description')->nullable();
            $table->foreignId('image')->nullable()->constrained('uploads')->nullOnDelete();
            $table->foreignId('banner_image')->nullable()->constrained('uploads')->nullOnDelete();
            $table->unsignedInteger('position')->nullable()->default(0);
            $table->boolean('status')->default(Status::ACTIVE)->comment(Status::ACTIVE . ' = Active ,' . Status::INACTIVE . ' = Inactive');
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
        Schema::dropIfExists('services');
    }
};

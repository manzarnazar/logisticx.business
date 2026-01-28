<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use App\Enums\Status;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('image')->nullable()->constrained('uploads')->onDelete('cascade');
            $table->string('client_name');
            $table->string('designation');
            $table->string('rating');
            $table->text('description');
            $table->integer('position')->nullable()->default(0);
            $table->boolean('status')->default(\App\Enums\Status::ACTIVE)->comment('active = 1, inactive = 0');
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
        Schema::dropIfExists('testimonials');
    }
};

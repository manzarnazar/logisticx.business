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
        Schema::create('features', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->foreignId('image')->nullable()->constrained('uploads')->onDelete('cascade');
            $table->longText('description')->nullable();
            $table->bigInteger('position')->nullable();
            $table->unsignedBigInteger('status')->default(Status::ACTIVE)->comment(Status::ACTIVE.'= '.__('status.'.Status::ACTIVE).','.Status::INACTIVE.'= '.__('status.'.Status::INACTIVE));
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
        Schema::dropIfExists('features');
    }
};

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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->text('facebook_id')->nullable();
            $table->text('twitter_id')->nullable();
            $table->text('linkedIn_id')->nullable();
            $table->foreignId('logo')->nullable()->constrained('uploads')->onDelete('cascade');
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
        Schema::dropIfExists('clients');
    }
};

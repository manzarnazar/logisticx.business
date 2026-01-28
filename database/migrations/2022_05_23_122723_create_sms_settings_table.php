<?php

use App\Enums\AccountHeads;
use App\Enums\Status;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_settings', function (Blueprint $table) {
            $table->id();
            $table->string('gateway')->nullable();
            $table->longText('api_key')->nullable();
            $table->longText('secret_key')->nullable();
            $table->string('username')->nullable();
            $table->string('user_password')->nullable();
            $table->longText('api_url')->nullable();
            $table->unsignedTinyInteger('status')->default(Status::ACTIVE)->comment(Status::ACTIVE.'='.trans('status.'.Status::ACTIVE).', ' .Status::INACTIVE.'='.trans('status.'.Status::INACTIVE));
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
        Schema::dropIfExists('sms_settings');
    }
};

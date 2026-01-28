<?php

use App\Enums\Status;
use App\Enums\UserType;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->string('mobile')->nullable();
            $table->string('nid_number')->nullable();
            $table->foreignId('designation_id')->nullable()->constrained('designations')->onDelete('cascade');
            $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('cascade');
            $table->foreignId('hub_id')->nullable()->constrained('hubs')->onDelete('cascade');
            $table->unsignedTinyInteger('user_type')->default(UserType::ADMIN)->comment(UserType::ADMIN . '= Admin, ' . UserType::MERCHANT . '= Merchant, ' . UserType::DELIVERYMAN . '= Hero, ' . UserType::INCHARGE . '= InChange')->nullable();
            $table->foreignId('image_id')->nullable()->constrained('uploads')->onDelete('cascade');
            $table->string('joining_date')->nullable();
            $table->string('address')->nullable();
            $table->foreignId('role_id')->nullable()->constrained('roles')->onDelete('cascade');
            $table->text('permissions')->nullable();
            $table->integer('otp')->nullable();
            $table->decimal('salary', 16, 2)->default(0);
            $table->string('device_token')->nullable();
            $table->string('web_token')->nullable();
            $table->unsignedTinyInteger('status')->default(Status::ACTIVE)->comment(Status::ACTIVE . '= Active, ' . Status::INACTIVE . '= Inactive');
            $table->unsignedTinyInteger('verification_status')->default(Status::ACTIVE)->comment(Status::ACTIVE . '= Active, ' . Status::INACTIVE . '= Inactive');
            $table->string('google_id')->unique()->nullable();
            $table->string('facebook_id')->unique()->nullable();
            $table->boolean('cookie_consent')->nullable()->comment('User cookie consent status: 1 = accepted, 0 = declined, null = not responded');

            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Leave\Enums\LeaveRequestStatus;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('role_id')->nullable()->constrained('roles')->nullOnDelete();
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->string('name')->nullable();
            $table->date('date')->nullable();
            $table->integer('days')->nullable();
            $table->foreignId('type_id')->nullable()->constrained('leave_types')->nullOnDelete();
            $table->foreignId('file_id')->nullable()->constrained('uploads')->onDelete('cascade');
            $table->unsignedBigInteger('status')->default(LeaveRequestStatus::PENDING)->comment('1= Pendin, 2 = approve, 3=rejected');
            $table->text('reason')->nullable();
            $table->longtext('note')->nullable();

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
        Schema::dropIfExists('leave_requests');
    }
};

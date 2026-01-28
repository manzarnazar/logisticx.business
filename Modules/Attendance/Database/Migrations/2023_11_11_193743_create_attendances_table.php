<?php

use App\Enums\Status;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\Attendance\Enums\AttendanceType;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->date('date')->comment('Attendance date');
            $table->time('check_in')->nullable()->comment('In time');
            $table->time('check_out')->nullable()->comment('Out time');
            $table->tinyInteger('type')->default(AttendanceType::PRESENT)->comment('0 = Absent, 1 = Present, 2 = Leave');
            $table->string('note')->nullable();

            $table->timestamps();

            $table->unique(['user_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances');
    }
};

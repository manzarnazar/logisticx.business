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
        Schema::create('leave_assigns', function (Blueprint $table) {
            $table->id();

            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->foreignId('type_id')->nullable()->constrained('leave_types')->nullOnDelete();
            $table->integer('days')->nullable();
            $table->unsignedBigInteger('status')->default(Status::ACTIVE)->comment('1= Active, 0 = Inactive');
            $table->bigInteger('position')->nullable();
            $table->timestamps();

            $table->unique(['department_id', 'type_id']); // This ensures uniqueness for the combination

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leave_assigns');
    }
};

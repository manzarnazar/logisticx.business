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
        Schema::create('holidays', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('from')->comment('Start Date');
            $table->date('to')->comment('End Date');
            $table->text('description')->nullable();
            $table->foreignId('file_id')->nullable()->comment('Upload ID')->constrained('uploads')->onUpdate('set null')->nullOnDelete();
            $table->boolean('status')->default(Status::INACTIVE)->comment(Status::ACTIVE . ' = Active'  . ', ' . Status::INACTIVE . ' = Inactive');
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
        Schema::dropIfExists('holidays');
    }
};

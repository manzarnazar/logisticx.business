<?php

use App\Enums\Status;
use App\Enums\SectionPadding;
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
        Schema::create('widgets', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('section')->nullable();

            $table->string('background')->nullable();
            $table->string('bg_color')->nullable();
            $table->foreignId('bg_image')->nullable()->constrained('uploads')->onDelete('cascade');

            // use enums section padding, array 
            $table->longText('section_padding')->nullable();

            $table->bigInteger('position')->nullable();
            $table->unsignedBigInteger('status')->default(Status::ACTIVE)->comment(Status::ACTIVE . '= ' . __('status.' . Status::ACTIVE) . ',' . Status::INACTIVE . '= ' . __('status.' . Status::INACTIVE));
            
            if (config('app.app_demo')) :
                $table->string('demo_style')->default(1);
            endif;
            
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
        Schema::dropIfExists('widgets');
    }
};

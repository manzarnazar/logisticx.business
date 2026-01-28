<?php

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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();

            $table->foreignId('account_head_id')->nullable()->constrained('account_heads')->onDelete('cascade');
            $table->foreignId('bank_transaction_id')->nullable()->comment('from')->constrained('bank_transactions')->onDelete('cascade');
            $table->foreignId('to_bank_transaction_id')->nullable()->comment('to')->constrained('bank_transactions')->onDelete('cascade');
            $table->foreignId('account_id')->nullable()->comment('From')->constrained('accounts')->onDelete('cascade');
            $table->decimal('amount', 16, 2)->nullable();
            $table->date('date')->nullable();
            $table->string('title', 100)->nullable();
            $table->text('note')->nullable();
            $table->foreignId('receipt')->nullable()->comment('upload id')->constrained('uploads')->onDelete('cascade');

            $table->foreignId('delivery_man_id')->nullable()->comment('receiver')->constrained('delivery_man')->onDelete('cascade');

            $table->foreignId('hub_id')->nullable()->constrained('hubs')->onDelete('cascade');
            $table->foreignId('hub_account_id')->nullable()->comment('To')->constrained('accounts')->onDelete('cascade');

            $table->timestamps();

            // $table->foreignId('merchant_id')->nullable()->constrained('merchants')->onDelete('cascade');
            // $table->foreignId('user_id')->nullable()->comment('receiver')->constrained('users')->onDelete('cascade');
            // $table->foreignId('user_account_id')->nullable()->comment('To')->constrained('accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenses');
    }
};

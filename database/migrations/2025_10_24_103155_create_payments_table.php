<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid();

            $table->string('name', 20);
            $table->double('amount');
            $table->string('phone_number');
            $table->string('transaction_id', 10);
            $table->string('transaction_time');

            $table->string('token_value', 20);

            $table->string('account_number');
            $table->foreign('account_number')->references('account_number')->on('accounts');
            $table->index('account_number');
            
            $table->json('meta')->nullable();
            $table->string('msg')->nullable();

            $table->double('balance')->nullable();
            $table->integer('units')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

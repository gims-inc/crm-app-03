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
        Schema::create('accounts', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('account_number', 10)->unique();

            $table->uuid('customer_id');
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->index('customer_id');

            $table->uuid('product_id', 80)->unique()->nullable();// make unique ToDo
            $table->foreign('product_id')->references('id')->on('products');
            $table->index('product_id');

            $table->uuid('package_id', 80)->nullable(); //Added column --persist in your db
            $table->foreign('package_id')->references('id')->on('packages');
            $table->index('package_id');

            $table->uuid('staff_id', 80);
            $table->foreign('staff_id')->references('id')->on('users');

            $table->enum('status', ['pending', 'active', 'inactive', 'suspended', 'closed'])->default('pending'); //active,inactive,suspended,closed

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};

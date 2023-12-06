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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('serial_number', 20);//(unique)
            $table->string('batch_number', 10); //date+username+productname
            $table->string('product_name', 20);

            // $table->uuid('package_id')->nullable(); //(fk)
            // $table->foreign('package_id')->references('id')->on('packages');

            $table->uuid('staff_id');
            $table->foreign('staff_id')->references('id')->on('users');

            $table->enum('whereAt', ['field','production', 'repairs', 'decomissioned'])->default('production');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

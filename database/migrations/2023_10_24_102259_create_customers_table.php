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
        Schema::create('customers', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->integer('national_id')->unique();
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->string('other_name', 100)->nullable();
            $table->string('address', 150)->nullable();

            $table->string('primary_phone_number')->nullable();
            $table->string('secondary_phone_number')->nullable();

            $table->string('email', 100)->unique();

            $table->string('first_contact_name')->nullable(); 
            $table->string('first_contact_number')->nullable();

            $table->string('second_contact_name')->nullable();
            $table->string('second_contact_number')->nullable(); 

            $table->double('longitude')->nullable();
            $table->double('latitude')->nullable();

            $table->string('town', 100)->nullable();
            $table->string('village', 100)->nullable();

            $table->uuid('staff_id')->nullable();
            $table->foreign('staff_id')->references('id')->on('users');
            $table->index('staff_id');

            // $table->string('account_number')->nullable();
            $table->string('id_image')->nullable();

            $table->timestamps();
            // $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * ALTER TABLE packages ALTER COLUMN "totalAmount" type decimal(10, 2), ALTER COLUMN "dailyPayment" type decimal(10, 2);
     */
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->string('package_name', 50);
            $table->string('description');
            $table->decimal('daily_payment', 10,2);
            $table->decimal('total_amount', 10,2);

            $table->uuid('staff_id');
            $table->foreign('staff_id')->references('id')->on('users');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};

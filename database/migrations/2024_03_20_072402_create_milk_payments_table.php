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
        Schema::create('milk_payments', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id')->nullable();
            $table->string('image')->nullable();
            $table->integer('milk')->nullable();
            $table->integer('amount')->nullable();
            $table->date('date')->nullable();
            $table->string('status')->comment('0 = Pending, 1 = Paid')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('milk_payments');
    }
};

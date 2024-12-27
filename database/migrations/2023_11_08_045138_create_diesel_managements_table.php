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
        Schema::create('diesel_managements', function (Blueprint $table) {
            $table->id();
            $table->decimal('volume', 10, 2)->nullable(); // Assuming 'volume' is of type DECIMAL(10, 2)
            $table->decimal('price', 8, 2)->nullable(); // Assuming 'price' is of type DECIMAL(8, 2)
            $table->decimal('total_price', 12, 2)->nullable(); // Assuming 'total_price' is of type DECIMAL(12, 2)
            $table->date('date')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diesel_managements');
    }
};

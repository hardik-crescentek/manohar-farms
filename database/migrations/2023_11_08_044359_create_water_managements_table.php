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
        Schema::create('water_managements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('land_id')->nullable();
            $table->string('source')->nullable();
            $table->integer('volume')->nullable(); // Assuming volume is in liters, you can change the data type accordingly if needed
            $table->decimal('price', 10, 2)->nullable();
            $table->date('date')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();

            // Foreign key constraint to link land_id with the id in the 'lands' table
            $table->foreign('land_id')->references('id')->on('lands')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('water_managements', function (Blueprint $table) {
            $table->dropForeign(['land_id']);
        });

        Schema::dropIfExists('water_managements');
    }
};

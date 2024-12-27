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
        Schema::create('land_parts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('land_id')->nullable();
            $table->string('name')->nullable();
            $table->softDeletes(); // Adds the 'deleted_at' column for soft deletes
            $table->timestamps();
            
            // Define foreign key relationship
            $table->foreign('land_id')->references('id')->on('lands')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('land_parts');
    }
};

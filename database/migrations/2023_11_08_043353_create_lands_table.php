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
        Schema::create('lands', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('plant_id')->nullable();
            $table->string('image')->nullable();
            $table->string('name')->nullable();
            $table->text('address')->nullable();
            $table->text('documents')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();

            // Foreign key constraint to link land_id with the id in the 'plants' table
            $table->foreign('plant_id')->references('id')->on('plants')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lands', function (Blueprint $table) {
            $table->dropForeign(['plant_id']);
        });

        Schema::dropIfExists('lands');
    }
};

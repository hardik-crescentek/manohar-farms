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
        Schema::create('bore_and_wells', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['bore', 'wells'])->nullable();
            $table->enum('status', ['active', 'inactive'])->nullable()->default('active');
            $table->unsignedBigInteger('land_id')->nullable();
            $table->string('image')->nullable();
            $table->string('name')->nullable();
            $table->string('depth')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bore_and_wells');
    }
};

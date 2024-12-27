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
        Schema::create('vehicle_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->string('image')->nullable();
            $table->date('date')->nullable();
            $table->decimal('price', 8, 2)->nullable();
            $table->string('person')->nullable();
            $table->string('service')->nullable();
            $table->text('note')->nullable();
            $table->softDeletes(); // Adds a "deleted_at" column for soft deletes
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_services');
    }
};

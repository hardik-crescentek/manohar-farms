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
        Schema::create('diesel_entries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_id')->foreign('vehicle_id')->references('id')->on('vehicles_and_attachments');
            $table->decimal('volume', 10, 2)->nullable();
            $table->string('payment_person')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->date('date')->nullable();
            $table->text('notes')->nullable();
            $table->softDeletes(); // for deleted_at
            $table->timestamps(); // for created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diesel_entries');
    }
};

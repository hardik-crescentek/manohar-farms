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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('type')->nullable();
            $table->unsignedBigInteger('land_id')->nullable();
            $table->date('period_start')->nullable();
            $table->date('period_end')->nullable();
            $table->decimal('amount', 10, 2)->nullable(); // Assuming amount is in decimal format, adjust the precision and scale as needed
            $table->date('due_date')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 = unpaid, 1 = paid');
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
        Schema::table('bills', function (Blueprint $table) {
            $table->dropForeign(['land_id']);
        });

        Schema::dropIfExists('bills');
    }
};

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
        Schema::create('miscellaneouses', function (Blueprint $table) {
            $table->id();
            $table->string('heading');         // For the heading
            $table->string('image')->nullable(); // For storing the image path
            $table->string('pdf')->nullable();   // For storing the PDF path
            $table->year('year')->nullable();   // For storing a year
            $table->text('remarks')->nullable(); // For remarks or additional information
            $table->date('date')->nullable();   // For storing a date
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('miscellaneouses');
    }
};

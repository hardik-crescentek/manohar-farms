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
        Schema::create('vermi_compost', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->float('water')->nullable();
            $table->float('soil')->nullable();
            $table->float('worms')->nullable();
            $table->string('beds')->nullable();
            $table->date('date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vermi_compost');
    }
};

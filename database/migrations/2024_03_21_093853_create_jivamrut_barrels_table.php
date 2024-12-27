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
        Schema::create('jivamrut_barrels', function (Blueprint $table) {
            $table->id();
            $table->integer('jivamrut_fertilizer_id')->nullable();
            $table->string('name')->nullable();
            $table->integer('gaumutra')->nullable();
            $table->integer('worms')->nullable();
            $table->integer('water')->nullable();
            $table->date('date')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 = current, 1 = empty')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jivamrut_barrels');
    }
};

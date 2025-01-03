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
        Schema::create('plot_fertilizers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('land_id')->nullable();
            $table->string('land_part_id')->nullable();
            $table->string('fertilizer_name')->nullable();
            $table->integer('quantity')->default(0)->nullable();
            $table->date('date')->nullable();
            $table->time('time')->nullable();
            $table->decimal('volume', 8, 2)->nullable();
            $table->string('person')->nullable();
            $table->text('note')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('land_id')->references('id')->on('lands');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plot_fertilizers');
    }
};

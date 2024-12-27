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
        Schema::create('cows', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('mother')->nullable();
            $table->string('father')->nullable();
            $table->string('gender')->nullable();
            $table->string('tag_number')->nullable();
            $table->integer('age')->nullable();
            $table->string('grade')->nullable();
            $table->date('date')->nullable();
            $table->text('remark')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cows');
    }
};

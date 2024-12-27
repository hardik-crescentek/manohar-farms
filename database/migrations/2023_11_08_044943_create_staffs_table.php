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
        Schema::create('staffs', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->comment('1 = salaried staff, 2 = on demand')->nullable();
            $table->tinyInteger('is_leader')->comment('0 = no, 1 = yes')->default(0)->nullable();
            $table->string('role')->nullable();
            $table->string('name')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->text('address')->nullable();
            $table->decimal('salary', 10, 2)->nullable()->comment('For salaried staff');
            $table->decimal('rate_per_day', 10, 2)->nullable()->comment('For on-demand staff');
            $table->date('joining_date')->nullable();
            $table->date('resign_date')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staffs');
    }
};

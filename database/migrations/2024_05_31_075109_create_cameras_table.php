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
        Schema::create('cameras', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->string('camera_location')->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->date('purchase_date')->nullable();
            $table->string('memory_detail')->nullable();
            $table->string('sim_number')->nullable();
            $table->string('camera_company_name')->nullable();
            $table->string('service_person_name')->nullable();
            $table->string('service_person_number')->nullable();
            $table->string('recharge_notification')->nullable();
            $table->date('last_cleaning_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cameras');
    }
};

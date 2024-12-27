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
        Schema::create('notification_settings', function (Blueprint $table) {
            $table->id();
            $table->string('water')->nullable();
            $table->string('fertiliser')->nullable();
            $table->string('flushing')->nullable();
            $table->string('Jivamrut')->nullable();
            $table->string('vermi')->nullable();
            $table->string('plots_filter_cleaning')->nullable();
            $table->string('agenda_completion')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_settings');
    }
};

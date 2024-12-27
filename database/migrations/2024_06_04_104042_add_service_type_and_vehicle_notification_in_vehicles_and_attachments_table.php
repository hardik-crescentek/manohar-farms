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
        Schema::table('vehicles_and_attachments', function (Blueprint $table) {
            $table->tinyInteger('service_cycle_type')->comment('1 = days, 2 = hours')->nullable()->after('image');
            $table->string('vehicle_notification')->nullable()->after('service_cycle_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles_and_attachments', function (Blueprint $table) {
            $table->dropColumn('service_cycle_type');
            $table->dropColumn('vehicle_notification');
        });
    }
};

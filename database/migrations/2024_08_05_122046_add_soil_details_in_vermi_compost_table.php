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
        Schema::table('vermi_compost', function (Blueprint $table) {
            $table->date('completed_date')->after('date')->nullable();
            $table->string('soil_details')->after('soil')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vermi_compost', function (Blueprint $table) {
            $table->dropColumn('completed_date');
            $table->dropColumn('soil_details');
        });
    }
};

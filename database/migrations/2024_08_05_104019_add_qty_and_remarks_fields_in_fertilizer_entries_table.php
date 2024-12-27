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
        Schema::table('fertilizer_entries', function (Blueprint $table) {
            $table->integer('qty')->after('fertilizer_name')->nullable();
            $table->text('remarks')->after('qty')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fertilizer_entries', function (Blueprint $table) {
            $table->dropColumn('qty');
            $table->dropColumn('remarks');
        });
    }
};

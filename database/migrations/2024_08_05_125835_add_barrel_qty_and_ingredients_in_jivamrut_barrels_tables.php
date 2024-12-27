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
        Schema::table('jivamrut_barrels', function (Blueprint $table) {
            $table->string('ingredients')->after('name')->nullable();
            $table->integer('barrel_qty')->after('ingredients')->nullable();
            $table->date('removed_date')->after('status')->nullable();            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jivamrut_barrels', function (Blueprint $table) {
            $table->dropColumn('ingredients');
            $table->dropColumn('barrel_qty');
            $table->dropColumn('removed_date');
        });
    }
};

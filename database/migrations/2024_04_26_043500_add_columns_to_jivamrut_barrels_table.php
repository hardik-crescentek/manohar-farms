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
            $table->integer('chokha')->after('water')->nullable();
            $table->integer('god')->after('chokha')->nullable();
            $table->integer('chana')->after('god')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jivamrut_barrels', function (Blueprint $table) {
            $table->dropColumn('chokha');
            $table->dropColumn('god');
            $table->dropColumn('chana');
        });
    }
};

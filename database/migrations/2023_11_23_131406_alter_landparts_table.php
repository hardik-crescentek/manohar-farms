<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('land_parts', function (Blueprint $table) {
            $table->string('image')->after('land_id')->nullable();
            $table->integer('plants')->after('image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('land_parts', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->dropColumn('plants');
        });
    }
};

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
        Schema::create('vehicles_and_attachments', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->comment('1 = vehicle, 2 = attachment')->nullable();
            $table->string('name')->nullable();
            $table->string('number')->nullable();
            $table->text('documents')->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles_and_attachments');
    }
};

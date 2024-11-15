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
        Schema::create('attendance_shifts', function (Blueprint $table) {
            $table->id();

            $table->string('name',50);
            $table->time('in_time');
            $table->time('out_time');
            $table->time('in_buffer_time')->nullable();
            $table->time('out_buffer_time')->nullable();
            $table->time('working_hour')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_shifts');
    }
};

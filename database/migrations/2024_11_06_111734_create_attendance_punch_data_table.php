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
        Schema::create('attendance_punch_data', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id');
            $table->string('emp_code',20);
            $table->date('punch_date');
            $table->time('punch_time');
            $table->string('terminal_id');
            $table->string('status',10)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_punch_data');
    }
};

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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id');
            $table->string('emp_code');
            $table->date('punch_date');
            $table->time('in_time')->nullable();
            $table->time('out_time')->nullable();
            $table->time('s_in_time')->nullable();
            $table->time('s_out_time')->nullable();
            $table->time('working_hour')->nullable();
            $table->time('late_by')->nullable();
            $table->time('early_going_by')->nullable();
            $table->time('overtime')->nullable();
            $table->integer('leave_type_id')->nullable();
            $table->string('status',20)->nullable();
            $table->boolean('is_processed')->default(0);
            $table->string('remarks',255)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};

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
        Schema::create('leave_applications', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id');
            $table->string('emp_code',20);
            $table->string('applied_for',10)->default('self');
            $table->integer('leave_type_id');
            $table->date('from_date');
            $table->date('to_date');
            $table->date('applied_from_date');
            $table->date('applied_to_date');
            $table->string('is_half_day',10);
            $table->date('half_day_on')->nullable();
            $table->longText('reason');
            $table->string('attachments')->nullable();
            $table->string('status',15);
            $table->string('from_users',50)->nullable();
            $table->string('to_users',50)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_applications');
    }
};

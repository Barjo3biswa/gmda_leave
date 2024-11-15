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
        Schema::create('leave_availabilities', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id');
            $table->string('emp_code',20);
            $table->integer('leave_type_id');
            $table->float('available_count')->default(0);
            $table->float('used_count')->default(0);
            $table->float('used_count_as_on')->default(0);
            $table->date('last_credited_on')->nullable();
            $table->date('last_used_on')->nullable();
            $table->string('calander_year',10);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_availabilities');
    }
};

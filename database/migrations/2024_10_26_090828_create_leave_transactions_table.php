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
        Schema::create('leave_transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('emp_id');
            $table->string('emp_code',20);
            $table->string('transaction_type',10);
            $table->integer('leave_type_id');
            $table->float('available_count')->default(0);
            $table->float('used_count')->default(0);
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->float('credited_count')->default(0);
            $table->date('credited_on')->nullable();
            $table->float('used_count_as_on')->default(0);
            $table->date('used_on')->nullable();
            $table->longText('remarks')->nullable();
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
        Schema::dropIfExists('leave_transactions');
    }
};

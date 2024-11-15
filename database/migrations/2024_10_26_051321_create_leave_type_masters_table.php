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
        Schema::create('leave_type_masters', function (Blueprint $table) {
            $table->id();

            $table->string('name',60)->nullable();
            $table->string('gender',20)->nullable();
            $table->integer('max_leave')->nullable();
            $table->string('accommodation_period',20)->nullable();
            $table->integer('max_limit')->nullable();
            $table->string('limit_period',20)->nullable();
            $table->string('can_apply',20)->nullable();
            $table->string('can_apply_at',20)->nullable();
            $table->integer('min_allowed')->nullable();
            $table->integer('max_allowed')->nullable();
            $table->string('pay_type',20)->nullable();
            $table->integer('credit_count')->nullable();
            $table->string('credit_intervel',20)->nullable();
            $table->string('credit_time',20)->nullable();
            $table->string('status',20)->default('Active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_type_masters');
    }
};

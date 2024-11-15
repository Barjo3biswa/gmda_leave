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
        Schema::table('leave_type_masters', function (Blueprint $table) {
            $table->string('is_sandwich',10)->default('no');
            $table->string('is_half_pay_link',10)->default('no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('leave_type_masters', function (Blueprint $table) {
            //
        });
    }
};

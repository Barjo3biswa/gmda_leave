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
        Schema::table('attendance_shifts', function (Blueprint $table) {
            $table->time('f_half_out_time')->after('in_time')->nullable();
            $table->time('s_half_in_time')->after('f_half_out_time')->nullable();

            $table->string('sec_sat_off',5)->after('working_hour')->default('no');
            $table->string('for_sat_off',5)->after('sec_sat_off')->default('no');
            //
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendance_shifts', function (Blueprint $table) {
            //
        });
    }
};

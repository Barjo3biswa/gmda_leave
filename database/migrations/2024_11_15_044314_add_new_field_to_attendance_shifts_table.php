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
            $table->string('fir_sat_off',5)->default('no')->after('h_d_working_hour');
            $table->string('thir_sat_off',5)->default('no')->after('sec_sat_off');
            $table->string('fif_sat_off',5)->default('no')->after('for_sat_off');
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

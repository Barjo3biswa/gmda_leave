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
        Schema::create('leave_application_trans', function (Blueprint $table) {
            $table->id();
            $table->integer('application_id');
            $table->integer('from_user',);
            $table->integer('to_user',);
            $table->dateTime('date',);
            $table->string('status',15);
            $table->longText('remarks',)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_application_trans');
    }
};

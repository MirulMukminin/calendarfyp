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
        Schema::create('courses', function (Blueprint $table) {
            $table->id('id');
            $table->string('course_code');
            $table->string('course_name');
            $table->string('occ');
            $table->string('lecturer');
            $table->string('lecturer_id');
            $table->string('type');
            $table->string('time_start');
            $table->string('time_end');
            $table->string('day');
            $table->string('semester');
            $table->string('session');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};

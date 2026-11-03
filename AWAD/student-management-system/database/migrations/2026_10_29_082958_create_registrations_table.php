<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->string('academic_year');
            $table->string('semester');
            $table->timestamps();

            // Prevent duplicate registration per academic year & semester
            $table->unique(['user_id', 'course_id', 'academic_year', 'semester'], 'unique_registration');
        });
    }

    public function down(): void {
        Schema::dropIfExists('registrations');
    }
};
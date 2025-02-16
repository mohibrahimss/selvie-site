<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mentor_student', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // mentor
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->string('role')->default('mentor');
            $table->date('assigned_at');
            $table->date('ended_at')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'student_id', 'role']);
            $table->index(['user_id', 'role']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mentor_student');
    }
}; 
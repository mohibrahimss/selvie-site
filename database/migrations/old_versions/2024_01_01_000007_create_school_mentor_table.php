<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('school_mentor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // mentor
            $table->string('role')->default('mentor');
            $table->date('joined_at');
            $table->date('left_at')->nullable();
            $table->timestamps();
            
            $table->unique(['school_id', 'user_id', 'role']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_mentor');
    }
}; 
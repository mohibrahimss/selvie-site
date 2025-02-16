<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->longText('content');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->timestamps();
            
            $table->index(['school_id', 'status']);
            $table->index(['start_date', 'end_date']);
        });

        Schema::create('mentor_training', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // mentor
            $table->foreignId('training_id')->constrained()->cascadeOnDelete();
            $table->string('role')->default('mentor');
            $table->enum('completion_status', ['not_started', 'in_progress', 'completed'])->default('not_started');
            $table->dateTime('completed_at')->nullable();
            $table->timestamps();
            
            $table->unique(['user_id', 'training_id', 'role']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mentor_training');
        Schema::dropIfExists('trainings');
    }
}; 
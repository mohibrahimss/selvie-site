<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('trainings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->onDelete('cascade');
            $table->foreignId('created_by_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('category');
            $table->string('level')->default('beginner');
            $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
            $table->integer('estimated_duration')->nullable(); // in minutes
            $table->boolean('is_required')->default(false);
            $table->dateTime('due_date')->nullable();
            $table->dateTime('published_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes for better performance
            $table->index(['team_id', 'status']);
            $table->index('category');
            $table->index('level');
            $table->index('is_required');
        });

        Schema::create('training_modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->text('description')->nullable();
            $table->longText('content')->nullable();
            $table->string('type'); // video, document, quiz, assignment, interactive
            $table->integer('order');
            $table->integer('estimated_duration')->nullable(); // in minutes
            $table->boolean('is_required')->default(true);
            $table->integer('passing_score')->default(80); // percentage
            $table->timestamps();
            $table->softDeletes();

            // Indexes for better performance
            $table->index(['training_id', 'order']);
            $table->index('type');
        });

        Schema::create('training_enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->dateTime('completed_at')->nullable();
            $table->dateTime('due_date')->nullable();
            $table->dateTime('last_activity_at')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Indexes for better performance
            $table->unique(['training_id', 'user_id']);
            $table->index('completed_at');
            $table->index('due_date');
        });

        Schema::create('training_module_completions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('training_module_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->integer('score')->nullable();
            $table->boolean('passed')->default(false);
            $table->dateTime('completed_at')->nullable();
            $table->integer('attempts')->default(0);
            $table->timestamps();
            $table->softDeletes();

            // Indexes for better performance
            $table->unique(['training_module_id', 'user_id']);
            $table->index('passed');
            $table->index('completed_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('training_module_completions');
        Schema::dropIfExists('training_enrollments');
        Schema::dropIfExists('training_modules');
        Schema::dropIfExists('trainings');
    }
}; 
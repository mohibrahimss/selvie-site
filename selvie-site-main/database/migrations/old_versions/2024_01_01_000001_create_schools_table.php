<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->text('address')->nullable();
            $table->string('contact_email');
            $table->string('phone')->nullable();
            $table->timestamps();
            
            $table->unique('team_id'); // Each team can only have one school
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
}; 
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingModuleCompletion extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'training_module_id',
        'user_id',
        'score',
        'passed',
        'completed_at',
        'attempts',
    ];

    protected $casts = [
        'score' => 'integer',
        'passed' => 'boolean',
        'completed_at' => 'datetime',
        'attempts' => 'integer',
    ];

    protected $attributes = [
        'attempts' => 0,
        'passed' => false,
    ];

    // Relationships
    public function module()
    {
        return $this->belongsTo(TrainingModule::class, 'training_module_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopePassed($query)
    {
        return $query->where('passed', true);
    }

    public function scopeFailed($query)
    {
        return $query->where('passed', false);
    }

    // Methods
    public function incrementAttempts()
    {
        $this->increment('attempts');
    }

    public function checkPassed()
    {
        if ($this->score === null) return false;
        return $this->score >= $this->module->passing_score;
    }

    public function updateScore($score)
    {
        $this->incrementAttempts();
        $passed = $score >= $this->module->passing_score;

        $this->update([
            'score' => $score,
            'passed' => $passed,
            'completed_at' => $passed ? now() : null,
        ]);

        // Check if all required modules are completed to mark the enrollment as completed
        if ($passed) {
            $enrollment = TrainingEnrollment::where([
                'training_id' => $this->module->training_id,
                'user_id' => $this->user_id,
            ])->first();

            if ($enrollment) {
                $allModulesCompleted = $this->module->training
                    ->modules()
                    ->required()
                    ->whereDoesntHave('completions', function ($query) {
                        $query->where('user_id', $this->user_id)
                            ->where('passed', true);
                    })
                    ->doesntExist();

                if ($allModulesCompleted) {
                    $enrollment->markAsCompleted();
                }
            }
        }

        return $this;
    }
} 
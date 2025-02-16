<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingModule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'training_id',
        'title',
        'description',
        'content',
        'type',
        'order',
        'estimated_duration',
        'is_required',
        'passing_score',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'order' => 'integer',
        'estimated_duration' => 'integer',
        'passing_score' => 'integer',
    ];

    protected $attributes = [
        'is_required' => true,
        'passing_score' => 80,
    ];

    // Relationships
    public function training()
    {
        return $this->belongsTo(Training::class);
    }

    public function completions()
    {
        return $this->hasMany(TrainingModuleCompletion::class);
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    // Scopes
    public function scopeRequired($query)
    {
        return $query->where('is_required', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    // Accessors & Mutators
    public function getCompletionRateAttribute()
    {
        if ($this->completions()->count() === 0) return 0;

        return round(
            ($this->completions()->where('passed', true)->count() / 
             $this->completions()->count()) * 100
        );
    }

    public function getIsCompletedByUserAttribute()
    {
        if (!auth()->check()) return false;

        return $this->completions()
            ->where('user_id', auth()->id())
            ->where('passed', true)
            ->exists();
    }

    // Methods
    public function markAsCompleted(User $user, $score = null, $passed = true)
    {
        return $this->completions()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'score' => $score,
                'passed' => $passed,
                'completed_at' => now(),
            ]
        );
    }

    public function resetForUser(User $user)
    {
        return $this->completions()
            ->where('user_id', $user->id)
            ->delete();
    }

    public static function getTypeOptions()
    {
        return [
            'video' => 'Video',
            'document' => 'Document',
            'quiz' => 'Quiz',
            'assignment' => 'Assignment',
            'interactive' => 'Interactive',
        ];
    }
} 
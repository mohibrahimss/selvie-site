<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrainingEnrollment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'training_id',
        'user_id',
        'completed_at',
        'due_date',
        'last_activity_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'due_date' => 'datetime',
        'last_activity_at' => 'datetime',
    ];

    // Relationships
    public function training()
    {
        return $this->belongsTo(Training::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function moduleCompletions()
    {
        return $this->hasMany(TrainingModuleCompletion::class, 'user_id', 'user_id')
            ->whereHas('module', function ($query) {
                $query->where('training_id', $this->training_id);
            });
    }

    // Scopes
    public function scopeCompleted($query)
    {
        return $query->whereNotNull('completed_at');
    }

    public function scopeIncomplete($query)
    {
        return $query->whereNull('completed_at');
    }

    public function scopeOverdue($query)
    {
        return $query->whereNull('completed_at')
            ->whereNotNull('due_date')
            ->where('due_date', '<', now());
    }

    // Accessors & Mutators
    public function getProgressAttribute()
    {
        $totalModules = $this->training->modules()->count();
        if ($totalModules === 0) return 0;

        $completedModules = $this->moduleCompletions()
            ->where('passed', true)
            ->count();

        return round(($completedModules / $totalModules) * 100);
    }

    public function getIsOverdueAttribute()
    {
        return !$this->completed_at && 
               $this->due_date && 
               $this->due_date->isPast();
    }

    public function getIsCompletedAttribute()
    {
        return $this->completed_at !== null;
    }

    // Methods
    public function markAsCompleted()
    {
        $this->update([
            'completed_at' => now(),
            'last_activity_at' => now(),
        ]);
    }

    public function updateLastActivity()
    {
        $this->update(['last_activity_at' => now()]);
    }

    public function reset()
    {
        $this->moduleCompletions()->delete();
        $this->update([
            'completed_at' => null,
            'last_activity_at' => now(),
        ]);
    }
} 
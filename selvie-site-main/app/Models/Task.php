<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'team_id',
        'assigned_by_id',
        'assigned_to_id',
        'title',
        'description',
        'status',
        'priority',
        'due_date',
        'completed_at',
        'category',
        'estimated_hours',
        'actual_hours',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'completed_at' => 'datetime',
        'estimated_hours' => 'float',
        'actual_hours' => 'float',
    ];

    protected $attributes = [
        'status' => 'pending',
        'priority' => 'medium',
    ];

    // Relationships
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }

    // Scopes
    public function scopeForTeam($query, $teamId)
    {
        return $query->where('team_id', $teamId);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())
                    ->whereNotIn('status', ['completed', 'cancelled']);
    }

    // Accessors & Mutators
    public function getIsOverdueAttribute()
    {
        return $this->due_date && $this->due_date->isPast() && 
               !in_array($this->status, ['completed', 'cancelled']);
    }

    public function getProgressPercentageAttribute()
    {
        return match($this->status) {
            'pending' => 0,
            'in_progress' => 50,
            'completed' => 100,
            'cancelled' => 0,
            default => 0,
        };
    }

    public function getTimeSpentAttribute()
    {
        return $this->actual_hours ?? 0;
    }

    // Methods
    public function markAsInProgress()
    {
        $this->update(['status' => 'in_progress']);
    }

    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }

    public function markAsCancelled()
    {
        $this->update(['status' => 'cancelled']);
    }

    public function logTime($hours, $description = null)
    {
        $this->increment('actual_hours', $hours);
        
        if ($description) {
            $this->comments()->create([
                'user_id' => auth()->id(),
                'content' => "Logged $hours hours: $description",
            ]);
        }
    }

    public static function getStatusOptions()
    {
        return [
            'pending' => 'Pending',
            'in_progress' => 'In Progress',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
        ];
    }

    public static function getPriorityOptions()
    {
        return [
            'low' => 'Low',
            'medium' => 'Medium',
            'high' => 'High',
            'urgent' => 'Urgent',
        ];
    }

    public static function getCategoryOptions()
    {
        return [
            'general' => 'General',
            'development' => 'Development',
            'design' => 'Design',
            'research' => 'Research',
            'documentation' => 'Documentation',
            'testing' => 'Testing',
            'meeting' => 'Meeting',
            'other' => 'Other',
        ];
    }
} 
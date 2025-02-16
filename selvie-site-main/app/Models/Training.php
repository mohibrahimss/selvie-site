<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Training extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'team_id',
        'title',
        'description',
        'category',
        'level',
        'status',
        'created_by_id',
        'estimated_duration',
        'is_required',
        'due_date',
        'published_at',
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'due_date' => 'datetime',
        'published_at' => 'datetime',
    ];

    protected $attributes = [
        'status' => 'draft',
        'is_required' => false,
    ];

    // Relationships
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function modules()
    {
        return $this->hasMany(TrainingModule::class)->orderBy('order');
    }

    public function enrollments()
    {
        return $this->hasMany(TrainingEnrollment::class);
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
    public function scopeForTeam($query, $teamId)
    {
        return $query->where('team_id', $teamId);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at');
    }

    public function scopeRequired($query)
    {
        return $query->where('is_required', true);
    }

    // Accessors & Mutators
    public function getIsPublishedAttribute()
    {
        return $this->status === 'published' && $this->published_at !== null;
    }

    public function getProgressForUserAttribute()
    {
        if (!auth()->check()) return 0;

        $enrollment = $this->enrollments()
            ->where('user_id', auth()->id())
            ->first();

        return $enrollment ? $enrollment->progress : 0;
    }

    public function getCompletionRateAttribute()
    {
        if ($this->enrollments()->count() === 0) return 0;

        return round(
            ($this->enrollments()->where('completed_at', '!=', null)->count() / 
             $this->enrollments()->count()) * 100
        );
    }

    // Methods
    public function publish()
    {
        $this->update([
            'status' => 'published',
            'published_at' => now(),
        ]);
    }

    public function unpublish()
    {
        $this->update([
            'status' => 'draft',
            'published_at' => null,
        ]);
    }

    public function archive()
    {
        $this->update(['status' => 'archived']);
    }

    public function enroll(User $user)
    {
        return $this->enrollments()->firstOrCreate([
            'user_id' => $user->id,
        ]);
    }

    public function isCompletedBy(User $user)
    {
        return $this->enrollments()
            ->where('user_id', $user->id)
            ->whereNotNull('completed_at')
            ->exists();
    }

    public static function getStatusOptions()
    {
        return [
            'draft' => 'Draft',
            'published' => 'Published',
            'archived' => 'Archived',
        ];
    }

    public static function getLevelOptions()
    {
        return [
            'beginner' => 'Beginner',
            'intermediate' => 'Intermediate',
            'advanced' => 'Advanced',
        ];
    }

    public static function getCategoryOptions()
    {
        return [
            'onboarding' => 'Onboarding',
            'technical' => 'Technical',
            'soft_skills' => 'Soft Skills',
            'compliance' => 'Compliance',
            'safety' => 'Safety',
            'leadership' => 'Leadership',
            'other' => 'Other',
        ];
    }
} 
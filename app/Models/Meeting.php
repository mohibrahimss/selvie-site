<?php

namespace App\Models;

use App\Notifications\MeetingScheduled;
use App\Notifications\MeetingUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Notification;

class Meeting extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'team_id',
        'mentor_id',
        'student_id',
        'title',
        'description',
        'start_time',
        'end_time',
        'status',
        'meeting_link',
        'notes'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    protected $attributes = [
        'status' => 'scheduled'
    ];

    protected static function booted()
    {
        static::created(function ($meeting) {
            $meeting->sendScheduledNotification();
        });

        static::updated(function ($meeting) {
            if ($meeting->wasChanged()) {
                $meeting->sendUpdatedNotification();
            }
        });
    }

    // Relationships
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Scopes
    public function scopeUpcoming($query)
    {
        return $query->where('start_time', '>', now())
                    ->where('status', 'scheduled')
                    ->orderBy('start_time', 'asc');
    }

    public function scopePast($query)
    {
        return $query->where('start_time', '<', now())
                    ->orderBy('start_time', 'desc');
    }

    public function scopeForTeam($query, $teamId)
    {
        return $query->where('team_id', $teamId);
    }

    // Accessors & Mutators
    public function getDurationAttribute()
    {
        return $this->start_time->diffInMinutes($this->end_time);
    }

    public function getIsUpcomingAttribute()
    {
        return $this->start_time->isFuture() && $this->status === 'scheduled';
    }

    public function getIsInProgressAttribute()
    {
        return $this->start_time->isPast() && 
               $this->end_time->isFuture() && 
               $this->status === 'in_progress';
    }

    public function getIsCompletedAttribute()
    {
        return $this->end_time->isPast() || $this->status === 'completed';
    }

    public function getCalendarEventAttribute()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'start' => $this->start_time->format('Y-m-d\TH:i:s'),
            'end' => $this->end_time->format('Y-m-d\TH:i:s'),
            'description' => $this->description,
            'mentor' => $this->mentor->name,
            'student' => $this->student->name,
            'status' => $this->status,
            'className' => $this->getStatusColorClass(),
            'editable' => $this->canBeModifiedBy(auth()->user()),
            'extendedProps' => [
                'meeting_link' => $this->meeting_link,
                'notes' => $this->notes,
            ],
        ];
    }

    public function getStatusColorClass()
    {
        return match($this->status) {
            'scheduled' => 'bg-blue-500 hover:bg-blue-600',
            'in_progress' => 'bg-yellow-500 hover:bg-yellow-600',
            'completed' => 'bg-green-500 hover:bg-green-600',
            'cancelled' => 'bg-red-500 hover:bg-red-600',
            default => 'bg-gray-500 hover:bg-gray-600',
        };
    }

    // Methods
    public function canBeModifiedBy(User $user)
    {
        return $user->hasTeamPermission($this->team, 'manage-meetings') ||
               $user->id === $this->mentor_id;
    }

    public function markAsInProgress()
    {
        $this->update(['status' => 'in_progress']);
    }

    public function markAsCompleted()
    {
        $this->update(['status' => 'completed']);
    }

    public function markAsCancelled()
    {
        $this->update(['status' => 'cancelled']);
    }

    // Notification Methods
    protected function sendScheduledNotification()
    {
        $recipients = collect([$this->mentor, $this->student]);
        Notification::send($recipients, new MeetingScheduled($this));
    }

    protected function sendUpdatedNotification()
    {
        $changes = array_intersect_key(
            $this->getChanges(),
            array_flip(['title', 'description', 'start_time', 'end_time', 'status', 'meeting_link'])
        );

        if (!empty($changes)) {
            $recipients = collect([$this->mentor, $this->student]);
            Notification::send($recipients, new MeetingUpdated($this, $changes));
        }
    }
} 
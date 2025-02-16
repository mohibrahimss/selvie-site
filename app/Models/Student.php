<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Jetstream\HasTeams;

class Student extends Model
{
    /** @use HasFactory<\Database\Factories\StudentFactory> */
    use HasFactory;
    use HasTeams;

    protected $fillable = [
        'name',
        'email',
        'school_id',
        'grade',
        'status'
    ];

    protected $casts = [
        'school_id' => 'integer',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function team()
    {
        return $this->belongsTo(Team::class, 'school_id', 'id');
    }

    public function mentors()
    {
        return $this->belongsToMany(User::class, 'mentor_student')
            ->wherePivot('role', 'mentor')
            ->withPivot(['assigned_at', 'ended_at']);
    }

    public function meetings()
    {
        return $this->hasMany(Meeting::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    // Scope to filter by team/school
    public function scopeForTeam($query, $team)
    {
        return $query->where('school_id', $team->id);
    }
}

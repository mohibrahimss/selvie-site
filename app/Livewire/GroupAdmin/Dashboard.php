<?php

namespace App\Livewire\GroupAdmin;

use Livewire\Component;
use App\Models\School;
use App\Models\User;
use App\Models\Student;

class Dashboard extends Component
{
    public $stats = [];
    public $schoolPerformance = [];
    public $mentorActivities = [];
    public $studentProgress = [];

    public function mount()
    {
        $this->loadStats();
        $this->loadSchoolPerformance();
        $this->loadMentorActivities();
        $this->loadStudentProgress();
    }

    protected function loadStats()
    {
        $groupSchools = auth()->user()->schools;
        
        $this->stats = [
            'total_schools' => $groupSchools->count(),
            'active_mentors' => User::role('mentor')
                ->whereIn('school_id', $groupSchools->pluck('id'))
                ->count(),
            'total_students' => Student::whereIn('school_id', $groupSchools->pluck('id'))
                ->count(),
            'support_requests' => \App\Models\SupportRequest::whereIn('school_id', $groupSchools->pluck('id'))
                ->where('status', 'pending')
                ->count(),
            'completion_rate' => $this->calculateCompletionRate($groupSchools)
        ];
    }

    protected function calculateCompletionRate($schools)
    {
        // Calculate average completion rate across all schools
        return 85; // Placeholder value
    }

    public function render()
    {
        return view('livewire.group-admin.dashboard')
            ->layout('layouts.group-admin');
    }
} 
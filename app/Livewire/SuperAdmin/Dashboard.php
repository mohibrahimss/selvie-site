<?php

namespace App\Livewire\SuperAdmin;

use Livewire\Component;
use App\Models\User;
use App\Models\School;
use App\Models\Student;
use App\Models\Training;

class Dashboard extends Component
{
    public $stats = [];
    public $recentActivities = [];
    public $systemAlerts = [];
    public $pendingApprovals = [];

    public function mount()
    {
        $this->loadStats();
        $this->loadRecentActivities();
        $this->loadSystemAlerts();
        $this->loadPendingApprovals();
    }

    protected function loadStats()
    {
        $this->stats = [
            'total_schools' => School::count(),
            'total_group_admins' => User::role('group_admin')->count(),
            'total_mentors' => User::role('mentor')->count(),
            'total_students' => Student::count(),
            'active_trainings' => Training::where('status', 'active')->count()
        ];
    }

    protected function loadRecentActivities()
    {
        $this->recentActivities = \App\Models\Activity::latest()
            ->take(5)
            ->get();
    }

    protected function loadSystemAlerts()
    {
        // Load system alerts, warnings, or notifications
        $this->systemAlerts = [
            'pending_updates' => false,
            'system_health' => 'good',
            'storage_usage' => '45%'
        ];
    }

    protected function loadPendingApprovals()
    {
        $this->pendingApprovals = User::where('status', 'pending_approval')
            ->latest()
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.super-admin.dashboard')
            ->layout('layouts.super-admin');
    }
} 
<?php

namespace App\Livewire\Mentor;

use Livewire\Component;

class Dashboard extends Component
{
    public $stats = [
        'activeStudents' => 0,
        'pendingTasks' => 0,
        'todayMeetings' => 0,
        'unreadMessages' => 0
    ];

    public $upcomingMeetings = [];
    public $recentActivity = [];

    public $selectedLocation = 'all';
    public $selectedSupportType = 'all';

    public function mount()
    {
        // Initialize stats with dummy data for now
        $this->stats = [
            'activeStudents' => 24,
            'pendingTasks' => 7,
            'todayMeetings' => 3,
            'unreadMessages' => 5
        ];

        // Initialize upcoming meetings with dummy data
        $this->upcomingMeetings = [
            [
                'title' => 'Weekly Check-in with John Doe',
                'time' => '10:00 AM',
                'duration' => '30 min',
                'status' => 'confirmed'
            ],
            [
                'title' => 'Progress Review with Jane Smith',
                'time' => '2:00 PM',
                'duration' => '45 min',
                'status' => 'pending'
            ]
        ];

        // Initialize recent activity with dummy data
        $this->recentActivity = [
            [
                'description' => 'Completed session with Sarah Johnson',
                'time' => '1 hour ago',
                'color' => 'green',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />'
            ],
            [
                'description' => 'New message from Mike Wilson',
                'time' => '2 hours ago',
                'color' => 'blue',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />'
            ],
            [
                'description' => 'Updated ISELP for Emily Brown',
                'time' => '3 hours ago',
                'color' => 'yellow',
                'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />'
            ]
        ];
    }

    public function render()
    {
        return view('livewire.mentor.dashboard');
    }

    public function filterSchools()
    {
        // In the future, we'll implement filtering logic here
    }

    public function toggleGoalStatus($goalId)
    {
        // In the future, we'll implement goal status toggling here
    }

    public function createNewMeeting()
    {
        // In the future, we'll implement meeting creation here
    }

    public function viewSchoolDetails($schoolId)
    {
        // In the future, we'll implement school details view here
    }

    public function respondToSchool($schoolId)
    {
        // In the future, we'll implement school response here
    }
} 
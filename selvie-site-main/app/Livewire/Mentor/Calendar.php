<?php

namespace App\Livewire\Mentor;

use Livewire\Component;
use Livewire\Attributes\On;

class Calendar extends Component
{
    public $view = 'month';
    public $currentDate;
    public $selectedDate = null;
    public $showMeetingModal = false;
    
    // Meeting Form Data
    public $meetingTitle = '';
    public $meetingType = '';
    public $meetingDate = '';
    public $meetingTime = '';
    public $meetingDuration = 60;
    public $meetingLocation = 'virtual';
    public $meetingParticipants = [];
    public $meetingAgenda = '';

    // Sample meeting types
    public $meetingTypes = [
        'student-review' => 'Student Review',
        'parent-conference' => 'Parent Conference',
        'iselp-planning' => 'ISELP Planning',
        'group-session' => 'Group Session',
        'school-visit' => 'School Visit'
    ];

    protected $rules = [
        'meetingTitle' => 'required|min:5',
        'meetingType' => 'required',
        'meetingDate' => 'required|date',
        'meetingTime' => 'required',
        'meetingDuration' => 'required|integer|min:15|max:180',
        'meetingLocation' => 'required',
        'meetingParticipants' => 'required|array|min:1',
        'meetingAgenda' => 'required|min:10'
    ];

    public function mount()
    {
        $this->currentDate = now();
        $this->meetingDate = now()->format('Y-m-d');
        $this->meetingTime = now()->format('H:i');
    }

    public function render()
    {
        return view('livewire.mentor.calendar', [
            'meetings' => $this->getMeetings()
        ]);
    }

    public function getMeetings()
    {
        // Sample meetings data - in the future, this will come from the database
        return collect([
            [
                'id' => 1,
                'title' => 'Student Review - John Doe',
                'start' => '2024-02-15 10:00:00',
                'end' => '2024-02-15 11:00:00',
                'type' => 'student-review',
                'participants' => ['John Doe', 'Jane Smith'],
                'location' => 'virtual',
                'status' => 'scheduled'
            ],
            [
                'id' => 2,
                'title' => 'Parent Conference - Smith Family',
                'start' => '2024-02-16 14:00:00',
                'end' => '2024-02-16 15:00:00',
                'type' => 'parent-conference',
                'participants' => ['Jane Smith', 'Parent Name'],
                'location' => 'Washington High School',
                'status' => 'scheduled'
            ]
        ]);
    }

    public function changeView($view)
    {
        $this->view = $view;
    }

    public function nextPeriod()
    {
        if ($this->view === 'month') {
            $this->currentDate = $this->currentDate->addMonth();
        } elseif ($this->view === 'week') {
            $this->currentDate = $this->currentDate->addWeek();
        } else {
            $this->currentDate = $this->currentDate->addDay();
        }
    }

    public function previousPeriod()
    {
        if ($this->view === 'month') {
            $this->currentDate = $this->currentDate->subMonth();
        } elseif ($this->view === 'week') {
            $this->currentDate = $this->currentDate->subWeek();
        } else {
            $this->currentDate = $this->currentDate->subDay();
        }
    }

    public function today()
    {
        $this->currentDate = now();
    }

    public function showCreateMeetingModal()
    {
        $this->resetMeetingForm();
        $this->showMeetingModal = true;
    }

    public function createMeeting()
    {
        $this->validate();

        // In the future, we'll save the meeting to the database
        $this->showMeetingModal = false;
        $this->dispatch('notify', [
            'message' => 'Meeting scheduled successfully',
            'type' => 'success'
        ]);
        $this->dispatch('refreshCalendar');

        $this->resetMeetingForm();
    }

    public function resetMeetingForm()
    {
        $this->meetingTitle = '';
        $this->meetingType = '';
        $this->meetingDate = now()->format('Y-m-d');
        $this->meetingTime = now()->format('H:i');
        $this->meetingDuration = 60;
        $this->meetingLocation = 'virtual';
        $this->meetingParticipants = [];
        $this->meetingAgenda = '';
    }

    #[On('meetingSelected')]
    public function handleMeetingSelected($meetingId)
    {
        // Handle meeting selection - could show details modal
        // For now, we'll just show a notification
        $this->dispatch('notify', [
            'message' => "Meeting {$meetingId} selected",
            'type' => 'info'
        ]);
    }

    #[On('meetingMoved')]
    public function handleMeetingMoved($eventData)
    {
        // Handle meeting being dragged to new time/date
        // In the future, this will update the database
        $this->dispatch('notify', [
            'message' => 'Meeting time updated successfully',
            'type' => 'success'
        ]);
        $this->dispatch('refreshCalendar');
    }

    #[On('meetingResized')]
    public function handleMeetingResized($eventData)
    {
        // Handle meeting duration being resized
        // In the future, this will update the database
        $this->dispatch('notify', [
            'message' => 'Meeting duration updated successfully',
            'type' => 'success'
        ]);
        $this->dispatch('refreshCalendar');
    }

    public function cancelMeeting($meetingId)
    {
        // In the future, we'll implement meeting cancellation here
        $this->dispatch('notify', [
            'message' => 'Meeting cancelled successfully',
            'type' => 'success'
        ]);
        $this->dispatch('refreshCalendar');
    }

    public function rescheduleMeeting($meetingId)
    {
        // In the future, we'll implement meeting rescheduling here
        // For now, we'll just show the create meeting modal
        $this->showCreateMeetingModal();
    }

    public function joinMeeting($meetingId)
    {
        // In the future, we'll implement meeting joining here
        // This could redirect to a video conferencing platform
        $this->dispatch('notify', [
            'message' => 'Joining meeting...',
            'type' => 'info'
        ]);
    }
} 
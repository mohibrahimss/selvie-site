<?php

namespace App\Livewire\Mentor;

use Livewire\Component;
use Livewire\WithFileUploads;

class StudentProfile extends Component
{
    use WithFileUploads;

    public $student;
    public $activeTab = 'overview';
    public $academicRecords = [];
    public $assessmentResults = [];
    public $newMessage = '';
    public $messages = [];
    public $newProgressNote = '';

    // Tabs: overview, upload, iselp, chat
    protected $tabs = ['overview', 'upload', 'iselp', 'chat'];

    protected $queryString = ['activeTab'];

    protected $listeners = [
        'tabChanged' => 'setTab',
        'refreshComponent' => '$refresh'
    ];

    public function mount($studentId)
    {
        // Mock student data - in the future, this will come from the database
        $this->student = [
            'id' => $studentId,
            'name' => 'John Doe',
            'avatar' => 'https://ui-avatars.com/api/?name=John+Doe&background=4F46E5&color=fff',
            'school' => 'Washington High School',
            'grade' => '10',
            'dob' => '2008-05-15',
            'guardian' => 'Jane Doe',
            'contact' => '(555) 123-4567',
            'stats' => [
                'assignments' => 24,
                'progress' => 78,
                'hours' => 45,
                'goals' => 12
            ],
            'subjects' => [
                [
                    'name' => 'Mathematics',
                    'progress' => 85
                ],
                [
                    'name' => 'English',
                    'progress' => 72
                ],
                [
                    'name' => 'Science',
                    'progress' => 90
                ],
                [
                    'name' => 'History',
                    'progress' => 65
                ]
            ],
            'sessions' => [
                [
                    'title' => 'Math Tutoring',
                    'date' => 'Feb 25, 2024',
                    'time' => '3:00 PM'
                ],
                [
                    'title' => 'Progress Review',
                    'date' => 'Feb 28, 2024',
                    'time' => '2:30 PM'
                ]
            ],
            'activities' => [
                [
                    'description' => 'Completed Math Assignment',
                    'time' => '2 hours ago',
                    'color' => 'green',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />'
                ],
                [
                    'description' => 'Started New Unit',
                    'time' => '4 hours ago',
                    'color' => 'blue',
                    'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />'
                ]
            ],
            'iselp_history' => [
                [
                    'id' => 1,
                    'date' => 'January 15, 2024',
                    'version' => '1.0',
                    'status' => 'Completed'
                ],
                [
                    'id' => 2,
                    'date' => 'February 1, 2024',
                    'version' => '1.1',
                    'status' => 'In Progress'
                ]
            ]
        ];

        // Mock chat messages
        $this->messages = [
            [
                'content' => 'Hello! How can I help you today?',
                'sender' => 'bot',
                'time' => '10:00 AM'
            ],
            [
                'content' => 'I need help with my math homework',
                'sender' => 'user',
                'time' => '10:01 AM'
            ],
            [
                'content' => 'I\'d be happy to help! What specific topic are you working on?',
                'sender' => 'bot',
                'time' => '10:01 AM'
            ]
        ];

        // Set initial tab from query string if valid
        if (request()->has('activeTab') && in_array(request()->activeTab, $this->tabs)) {
            $this->activeTab = request()->activeTab;
        }
    }

    public function editStudentInfo()
    {
        // This will be implemented to show an edit modal
        $this->dispatch('notify', [
            'message' => 'Edit functionality coming soon',
            'type' => 'info'
        ]);
    }

    public function uploadFiles()
    {
        // This will be implemented to handle file uploads
        $this->dispatch('notify', [
            'message' => 'Files uploaded successfully',
            'type' => 'success'
        ]);
    }

    public function generateISELP()
    {
        // This will be implemented to generate ISELP
        $this->dispatch('notify', [
            'message' => 'Generating ISELP...',
            'type' => 'info'
        ]);
    }

    public function viewISELP($iselpId)
    {
        // This will be implemented to view ISELP
        $this->dispatch('notify', [
            'message' => 'Viewing ISELP ' . $iselpId,
            'type' => 'info'
        ]);
    }

    public function downloadISELP($iselpId)
    {
        // This will be implemented to download ISELP
        $this->dispatch('notify', [
            'message' => 'Downloading ISELP ' . $iselpId,
            'type' => 'info'
        ]);
    }

    public function sendMessage()
    {
        if (empty($this->newMessage)) {
            return;
        }

        // Add user message
        $this->messages[] = [
            'content' => $this->newMessage,
            'sender' => 'user',
            'time' => now()->format('g:i A')
        ];

        // Mock bot response
        $this->messages[] = [
            'content' => 'I understand your message. How can I assist you further?',
            'sender' => 'bot',
            'time' => now()->format('g:i A')
        ];

        $this->newMessage = '';
    }

    public function render()
    {
        return view('livewire.mentor.student-profile');
    }

    public function setTab($tab)
    {
        if (in_array($tab, $this->tabs)) {
            $this->activeTab = $tab;
        }
    }

    public function saveIselpNotes()
    {
        // In the future, we'll implement saving ISELP notes here
        $this->dispatch('notify', [
            'message' => 'ISELP notes saved successfully',
            'type' => 'success'
        ]);
    }

    public function addProgressNote()
    {
        // Validate
        $this->validate([
            'newProgressNote' => 'required|min:10'
        ]);

        // In the future, we'll implement adding progress notes here
        $this->newProgressNote = '';
        
        $this->dispatch('notify', [
            'message' => 'Progress note added successfully',
            'type' => 'success'
        ]);
    }

    public function scheduleMeeting()
    {
        // In the future, we'll implement meeting scheduling here
    }

    public function shareResource()
    {
        // In the future, we'll implement resource sharing here
    }

    public function updateStudentStatus($status)
    {
        // In the future, we'll implement status updates here
        $this->student['status'] = $status;
        
        $this->dispatch('notify', [
            'message' => 'Student status updated successfully',
            'type' => 'success'
        ]);
    }
} 
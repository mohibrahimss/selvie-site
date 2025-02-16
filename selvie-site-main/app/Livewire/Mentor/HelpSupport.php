<?php

namespace App\Livewire\Mentor;

use Livewire\Component;

class HelpSupport extends Component
{
    public $activeTab = 'faq';
    public $search = '';
    public $showTicketModal = false;
    public $showGuideModal = false;
    public $selectedGuide = null;
    
    // Ticket Form Data
    public $ticketSubject = '';
    public $ticketDescription = '';
    public $ticketPriority = 'medium';
    public $ticketCategory = '';
    
    // Support categories
    public $categories = [
        'iselp' => 'ISELP Program',
        'platform' => 'Platform Usage',
        'students' => 'Student Management',
        'meetings' => 'Meetings & Calendar',
        'technical' => 'Technical Issues'
    ];
    
    // Priority levels
    public $priorities = [
        'low' => 'Low Priority',
        'medium' => 'Medium Priority',
        'high' => 'High Priority'
    ];

    protected $rules = [
        'ticketSubject' => 'required|min:5',
        'ticketDescription' => 'required|min:20',
        'ticketPriority' => 'required|in:low,medium,high',
        'ticketCategory' => 'required'
    ];

    public function render()
    {
        $faqs = $this->getFaqs();
        $guides = $this->getGuides();
        $tickets = $this->getTickets();
        
        return view('livewire.mentor.help-support', [
            'faqs' => $faqs,
            'guides' => $guides,
            'tickets' => $tickets
        ]);
    }

    public function getFaqs()
    {
        // Sample FAQs data - in the future, this will come from the database
        return [
            [
                'question' => 'How do I schedule a meeting with a student?',
                'answer' => 'To schedule a meeting, go to the Calendar section, click "Schedule Meeting", select the student, choose a date and time, and set the meeting details. The student will receive an automatic notification.',
                'category' => 'meetings'
            ],
            [
                'question' => 'What should I do if a student misses multiple sessions?',
                'answer' => 'First, document the absences in the student\'s profile. Then, reach out to both the student and their guardian. If the issue persists, contact your supervisor through the platform.',
                'category' => 'students'
            ],
            [
                'question' => 'How do I track ISELP progress?',
                'answer' => 'ISELP progress can be tracked through the student\'s profile under the "ISELP" tab. You can view assessments, add notes, and update progress markers for each component.',
                'category' => 'iselp'
            ]
        ];
    }

    public function getGuides()
    {
        // Sample guides data - in the future, this will come from the database
        return [
            [
                'id' => 1,
                'title' => 'Getting Started Guide',
                'description' => 'A comprehensive guide to help new mentors navigate the platform and understand their role.',
                'category' => 'platform',
                'sections' => [
                    ['title' => 'Platform Overview', 'content' => 'Learn about the key features and sections of the mentor portal.'],
                    ['title' => 'First Steps', 'content' => 'Essential tasks to complete when you first start mentoring.'],
                    ['title' => 'Best Practices', 'content' => 'Tips and guidelines for effective mentoring.']
                ]
            ],
            [
                'id' => 2,
                'title' => 'ISELP Assessment Guide',
                'description' => 'Learn how to conduct and document ISELP assessments effectively.',
                'category' => 'iselp',
                'sections' => [
                    ['title' => 'Assessment Process', 'content' => 'Step-by-step guide to conducting assessments.'],
                    ['title' => 'Documentation', 'content' => 'How to record and track assessment results.'],
                    ['title' => 'Progress Monitoring', 'content' => 'Guidelines for monitoring student progress.']
                ]
            ]
        ];
    }

    public function getTickets()
    {
        // Sample support tickets - in the future, this will come from the database
        return [
            [
                'id' => 1,
                'subject' => 'Cannot access student reports',
                'description' => 'When trying to view student progress reports, I get an error message.',
                'status' => 'open',
                'priority' => 'high',
                'category' => 'technical',
                'created_at' => '2024-02-14 10:30:00',
                'updated_at' => '2024-02-14 11:15:00'
            ],
            [
                'id' => 2,
                'subject' => 'Need clarification on ISELP scoring',
                'description' => 'I\'m unsure about how to score certain aspects of the ISELP assessment.',
                'status' => 'in-progress',
                'priority' => 'medium',
                'category' => 'iselp',
                'created_at' => '2024-02-13 15:20:00',
                'updated_at' => '2024-02-14 09:00:00'
            ]
        ];
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function showCreateTicket()
    {
        $this->resetTicketForm();
        $this->showTicketModal = true;
    }

    public function createTicket()
    {
        $this->validate();

        // In the future, this will save the ticket to the database
        $this->showTicketModal = false;
        $this->dispatch('notify', [
            'message' => 'Support ticket created successfully',
            'type' => 'success'
        ]);

        $this->resetTicketForm();
    }

    public function resetTicketForm()
    {
        $this->ticketSubject = '';
        $this->ticketDescription = '';
        $this->ticketPriority = 'medium';
        $this->ticketCategory = '';
    }

    public function viewGuide($guideId)
    {
        $this->selectedGuide = collect($this->getGuides())->firstWhere('id', $guideId);
        $this->showGuideModal = true;
    }

    public function contactSupport()
    {
        // In the future, this will initiate a live chat or support call
        $this->dispatch('notify', [
            'message' => 'Connecting to support...',
            'type' => 'info'
        ]);
    }
} 
<?php

namespace App\Livewire\Mentor;

use Livewire\Component;

class TrainingCenter extends Component
{
    public $activeTab = 'required';
    public $search = '';
    public $showCourseModal = false;
    public $selectedCourse = null;
    
    // Course categories
    public $categories = [
        'required' => 'Required Training',
        'iselp' => 'ISELP Methodology',
        'mentoring' => 'Mentoring Skills',
        'professional' => 'Professional Development',
        'technology' => 'Technology & Tools'
    ];
    
    public function render()
    {
        $courses = $this->getCourses();
        
        return view('livewire.mentor.training-center', [
            'courses' => $courses
        ]);
    }

    public function getCourses()
    {
        // Sample courses data - in the future, this will come from the database
        return [
            [
                'id' => 1,
                'title' => 'ISELP Fundamentals',
                'description' => 'Learn the core principles and methodologies of the ISELP program.',
                'category' => 'required',
                'duration' => '4 hours',
                'modules' => [
                    ['title' => 'Introduction to ISELP', 'status' => 'completed'],
                    ['title' => 'Assessment Methods', 'status' => 'in-progress'],
                    ['title' => 'Student Support Strategies', 'status' => 'pending'],
                    ['title' => 'Progress Tracking', 'status' => 'pending']
                ],
                'progress' => 25,
                'due_date' => '2024-03-01',
                'status' => 'in-progress'
            ],
            [
                'id' => 2,
                'title' => 'Effective Student Mentoring',
                'description' => 'Develop essential mentoring skills for supporting student growth and achievement.',
                'category' => 'mentoring',
                'duration' => '3 hours',
                'modules' => [
                    ['title' => 'Building Trust', 'status' => 'completed'],
                    ['title' => 'Communication Skills', 'status' => 'completed'],
                    ['title' => 'Goal Setting', 'status' => 'pending']
                ],
                'progress' => 66,
                'due_date' => '2024-02-28',
                'status' => 'in-progress'
            ],
            [
                'id' => 3,
                'title' => 'Digital Tools for Mentors',
                'description' => 'Master the digital tools and platforms used in the mentoring program.',
                'category' => 'technology',
                'duration' => '2 hours',
                'modules' => [
                    ['title' => 'Platform Overview', 'status' => 'completed'],
                    ['title' => 'Data Management', 'status' => 'completed'],
                    ['title' => 'Communication Tools', 'status' => 'completed']
                ],
                'progress' => 100,
                'due_date' => '2024-02-15',
                'status' => 'completed'
            ]
        ];
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function viewCourse($courseId)
    {
        $this->selectedCourse = collect($this->getCourses())->firstWhere('id', $courseId);
        $this->showCourseModal = true;
    }

    public function startModule($courseId, $moduleIndex)
    {
        // In the future, this will launch the module content and track progress
        $this->dispatch('notify', [
            'message' => 'Module started successfully',
            'type' => 'success'
        ]);
    }

    public function downloadCertificate($courseId)
    {
        // In the future, this will generate and download a completion certificate
        $this->dispatch('notify', [
            'message' => 'Certificate downloaded successfully',
            'type' => 'success'
        ]);
    }

    public function getProgress($modules)
    {
        $completed = collect($modules)->where('status', 'completed')->count();
        return round(($completed / count($modules)) * 100);
    }
} 
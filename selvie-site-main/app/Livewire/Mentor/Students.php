<?php

namespace App\Livewire\Mentor;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Pagination\LengthAwarePaginator;

class Students extends Component
{
    use WithPagination;

    public $search = '';
    public $filter = 'all';
    public $gradeLevel = '';
    public $school = '';
    public $supportType = '';
    public $iselpStatus = '';
    public $students = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'filter' => ['except' => 'all'],
        'gradeLevel' => ['except' => ''],
        'school' => ['except' => ''],
        'supportType' => ['except' => ''],
        'iselpStatus' => ['except' => ''],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingFilter()
    {
        $this->resetPage();
    }

    public function updatingGradeLevel()
    {
        $this->resetPage();
    }

    public function updatingSchool()
    {
        $this->resetPage();
    }

    public function updatingSupportType()
    {
        $this->resetPage();
    }

    public function updatingIselpStatus()
    {
        $this->resetPage();
    }

    public function mount()
    {
        // Initialize with dummy data for now
        $this->students = [
            [
                'id' => 1,
                'name' => 'John Doe',
                'avatar' => 'https://ui-avatars.com/api/?name=John+Doe&background=4F46E5&color=fff',
                'grade' => '10',
                'school' => 'Washington High',
                'status' => 'active',
                'support_type' => 'Academic',
                'last_meeting' => '2024-03-15',
                'iselp_status' => 'Active'
            ],
            [
                'id' => 2,
                'name' => 'Jane Smith',
                'avatar' => 'https://ui-avatars.com/api/?name=Jane+Smith&background=4F46E5&color=fff',
                'grade' => '11',
                'school' => 'Lincoln Elementary',
                'status' => 'needs_attention',
                'support_type' => 'Behavioral',
                'last_meeting' => '2024-03-10',
                'iselp_status' => 'Pending Review'
            ],
            [
                'id' => 3,
                'name' => 'Mike Wilson',
                'avatar' => 'https://ui-avatars.com/api/?name=Mike+Wilson&background=4F46E5&color=fff',
                'grade' => '9',
                'school' => 'Washington High',
                'status' => 'inactive',
                'support_type' => 'Attendance',
                'last_meeting' => '2024-03-05',
                'iselp_status' => 'Completed'
            ]
        ];
    }

    public function render()
    {
        $filteredStudents = collect($this->students)
            ->when($this->search, function ($collection) {
                return $collection->filter(function ($student) {
                    return str_contains(strtolower($student['name']), strtolower($this->search)) ||
                           str_contains($student['id'], $this->search);
                });
            })
            ->when($this->filter !== 'all', function ($collection) {
                return $collection->where('status', $this->filter);
            })
            ->when($this->gradeLevel, function ($collection) {
                return $collection->where('grade', $this->gradeLevel);
            })
            ->when($this->school, function ($collection) {
                return $collection->where('school', $this->school);
            })
            ->when($this->supportType, function ($collection) {
                return $collection->where('support_type', $this->supportType);
            })
            ->when($this->iselpStatus, function ($collection) {
                return $collection->where('iselp_status', $this->iselpStatus);
            });

        // Create a paginator instance
        $perPage = 10;
        $currentPage = $this->page ?? 1;
        $items = $filteredStudents->values();
        $paginator = new LengthAwarePaginator(
            $items->forPage($currentPage, $perPage),
            $items->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url()]
        );

        // Create pagination data for the view
        $pagination = [
            'from' => $paginator->firstItem() ?? 0,
            'to' => $paginator->lastItem() ?? 0,
            'total' => $paginator->total(),
            'current_page' => $paginator->currentPage(),
            'last_page' => $paginator->lastPage(),
            'has_more_pages' => $paginator->hasMorePages(),
        ];
        
        return view('livewire.mentor.students', [
            'students' => $paginator->items(),
            'pagination' => $pagination
        ]);
    }

    public function scheduleSession($studentId)
    {
        // This will be implemented later to handle session scheduling
    }

    public function viewProfile($studentId)
    {
        // In the future, we'll implement profile view here
    }

    public function scheduleMeeting($studentId)
    {
        // In the future, we'll implement meeting scheduling here
    }

    public function scheduleGroupMeeting()
    {
        // In the future, we'll implement group meeting scheduling here
    }

    public function exportData()
    {
        // In the future, we'll implement data export here
    }
} 
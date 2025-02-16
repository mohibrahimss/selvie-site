<?php

namespace App\Livewire\Mentor;

use Livewire\Component;

class Tasks extends Component
{
    public $showTaskModal = false;
    public $filter = 'all';
    public $search = '';
    
    // Task Form Data
    public $taskTitle = '';
    public $taskDescription = '';
    public $taskType = '';
    public $dueDate = '';
    public $priority = 'medium';
    public $status = 'pending';
    public $relatedStudent = null;
    
    // Task type options
    public $taskTypes = [
        'iselp' => 'ISELP Planning',
        'student-support' => 'Student Support',
        'documentation' => 'Documentation',
        'meeting-prep' => 'Meeting Preparation',
        'follow-up' => 'Follow-up Action',
        'training' => 'Training Task'
    ];
    
    // Priority options
    public $priorities = [
        'high' => 'High',
        'medium' => 'Medium',
        'low' => 'Low'
    ];
    
    protected $rules = [
        'taskTitle' => 'required|min:5',
        'taskDescription' => 'required|min:10',
        'taskType' => 'required',
        'dueDate' => 'required|date',
        'priority' => 'required|in:high,medium,low',
        'status' => 'required|in:pending,in-progress,completed,cancelled'
    ];

    public function render()
    {
        $tasks = $this->getTasks();
        
        // Calculate stats from tasks
        $stats = [
            'total' => count($tasks),
            'pending' => count(array_filter($tasks, fn($task) => $task['status'] === 'pending')),
            'in_progress' => count(array_filter($tasks, fn($task) => $task['status'] === 'in-progress')),
            'completed' => count(array_filter($tasks, fn($task) => $task['status'] === 'completed'))
        ];
        
        return view('livewire.mentor.tasks', [
            'tasks' => $tasks,
            'stats' => $stats
        ]);
    }

    public function getTasks()
    {
        // Sample tasks data - in the future, this will come from the database
        return [
            [
                'id' => 1,
                'title' => 'Complete ISELP Assessment for John Doe',
                'description' => 'Review and complete the initial ISELP assessment for new student John Doe.',
                'type' => 'iselp',
                'due_date' => '2024-02-20',
                'priority' => 'high',
                'status' => 'pending',
                'related_student' => 'John Doe'
            ],
            [
                'id' => 2,
                'title' => 'Follow up on Math Progress',
                'description' => 'Check in with math teacher regarding Jane Smith\'s recent improvement in algebra.',
                'type' => 'follow-up',
                'due_date' => '2024-02-18',
                'priority' => 'medium',
                'status' => 'in-progress',
                'related_student' => 'Jane Smith'
            ]
        ];
    }

    public function showCreateTaskModal()
    {
        $this->resetTaskForm();
        $this->showTaskModal = true;
    }

    public function createTask()
    {
        $this->validate();

        // In the future, we'll save the task to the database
        $this->showTaskModal = false;
        $this->dispatch('notify', [
            'message' => 'Task created successfully',
            'type' => 'success'
        ]);

        $this->resetTaskForm();
    }

    public function resetTaskForm()
    {
        $this->taskTitle = '';
        $this->taskDescription = '';
        $this->taskType = '';
        $this->dueDate = '';
        $this->priority = 'medium';
        $this->status = 'pending';
        $this->relatedStudent = null;
    }

    public function updateTaskStatus($taskId, $newStatus)
    {
        // In the future, we'll update the task status in the database
        $this->dispatch('notify', [
            'message' => 'Task status updated successfully',
            'type' => 'success'
        ]);
    }

    public function deleteTask($taskId)
    {
        // In the future, we'll delete the task from the database
        $this->dispatch('notify', [
            'message' => 'Task deleted successfully',
            'type' => 'success'
        ]);
    }

    public function setFilter($filter)
    {
        $this->filter = $filter;
    }
} 
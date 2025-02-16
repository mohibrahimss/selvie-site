<!-- Tasks Page -->
<div class="mx-auto space-y-6 max-w-[1280px]">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-gradient">
            <div class="page-header-content">
                <h1 class="page-title">Tasks & Activities</h1>
                <p class="page-subtitle">Manage and track your tasks and student activities.</p>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="w-full">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Total Tasks -->
            <div class="stats-card">
                <div class="stats-card-icon bg-primary-100">
                    <svg class="h-6 w-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <div class="stats-card-content">
                    <h4 class="stats-card-label">Total Tasks</h4>
                    <p class="stats-card-value">{{ $stats['total'] }}</p>
                </div>
            </div>

            <!-- Pending Tasks -->
            <div class="stats-card">
                <div class="stats-card-icon bg-yellow-100">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="stats-card-content">
                    <h4 class="stats-card-label">Pending</h4>
                    <p class="stats-card-value">{{ $stats['pending'] }}</p>
                </div>
            </div>

            <!-- In Progress -->
            <div class="stats-card">
                <div class="stats-card-icon bg-blue-100">
                    <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div class="stats-card-content">
                    <h4 class="stats-card-label">In Progress</h4>
                    <p class="stats-card-value">{{ $stats['in_progress'] }}</p>
                </div>
            </div>

            <!-- Completed -->
            <div class="stats-card">
                <div class="stats-card-icon bg-green-100">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="stats-card-content">
                    <h4 class="stats-card-label">Completed</h4>
                    <p class="stats-card-value">{{ $stats['completed'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="card">
        <div class="card-body">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex flex-wrap gap-2">
                    <button wire:click="setFilter('all')" 
                            class="tab {{ $filter === 'all' ? 'tab-active' : '' }}">
                        All
                    </button>
                    <button wire:click="setFilter('pending')" 
                            class="tab {{ $filter === 'pending' ? 'tab-active' : '' }}">
                        Pending
                    </button>
                    <button wire:click="setFilter('in-progress')" 
                            class="tab {{ $filter === 'in-progress' ? 'tab-active' : '' }}">
                        In Progress
                    </button>
                    <button wire:click="setFilter('completed')" 
                            class="tab {{ $filter === 'completed' ? 'tab-active' : '' }}">
                        Completed
                    </button>
                </div>
                <div class="flex items-center gap-4">
                    <div class="relative">
                        <input type="text" 
                               wire:model.debounce.300ms="search" 
                               class="form-input pl-10" 
                               placeholder="Search tasks...">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                    <button type="button" 
                            wire:click="showCreateTaskModal" 
                            class="btn btn-primary">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Create Task</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tasks List -->
    <div class="card">
        <div class="card-body">
            <ul class="divide-y divide-gray-100">
                @forelse ($tasks as $task)
                    <li class="hover:bg-gray-50 transition-colors p-4 rounded-lg">
                        <div class="flex items-center justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start gap-4">
                                    <!-- Priority indicator -->
                                    <span class="flex-shrink-0 w-2 h-2 mt-2 rounded-full {{ 
                                        $task['priority'] === 'high' ? 'bg-red-400' : 
                                        ($task['priority'] === 'medium' ? 'bg-yellow-400' : 'bg-green-400') 
                                    }}"></span>
                                    
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-base font-semibold text-gray-900 line-clamp-1">
                                            {{ $task['title'] }}
                                        </h3>
                                        <p class="mt-1 text-sm text-gray-500 line-clamp-2">
                                            {{ $task['description'] }}
                                        </p>
                                        <div class="mt-2 flex flex-wrap items-center gap-4 text-sm text-gray-500">
                                            <div class="flex items-center gap-1.5">
                                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                                <span>Due: {{ \Carbon\Carbon::parse($task['due_date'])->format('M j, Y') }}</span>
                                            </div>
                                            
                                            @if($task['related_student'])
                                                <div class="flex items-center gap-1.5">
                                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                    <span>{{ $task['related_student'] }}</span>
                                                </div>
                                            @endif
                                            
                                            <span class="badge {{ 
                                                $task['type'] === 'iselp' ? 'badge-purple' :
                                                ($task['type'] === 'student-support' ? 'badge-blue' :
                                                ($task['type'] === 'documentation' ? 'badge-green' :
                                                ($task['type'] === 'meeting-prep' ? 'badge-yellow' :
                                                ($task['type'] === 'follow-up' ? 'badge-red' : 'badge-gray'))))
                                            }}">
                                                {{ $taskTypes[$task['type']] }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-4">
                                <select wire:change="updateTaskStatus({{ $task['id'] }}, $event.target.value)" 
                                        class="form-select">
                                    <option value="pending" {{ $task['status'] === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="in-progress" {{ $task['status'] === 'in-progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="completed" {{ $task['status'] === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="cancelled" {{ $task['status'] === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                                
                                <button type="button" 
                                        wire:click="deleteTask({{ $task['id'] }})" 
                                        class="btn btn-icon btn-error">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="p-4">
                        <div class="text-center text-gray-500">
                            No tasks found. Create a new task to get started!
                        </div>
                    </li>
                @endforelse
            </ul>
        </div>
    </div>

    <!-- Create Task Modal -->
    <div x-show="$wire.showTaskModal" 
         class="modal"
         x-cloak
         x-transition>
        <div class="modal-backdrop"></div>

        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Create New Task</h3>
            </div>
            
            <div class="modal-body space-y-4">
                <div>
                    <label for="task-title" class="form-label">Title</label>
                    <input type="text" 
                           wire:model="taskTitle" 
                           id="task-title" 
                           class="form-input">
                </div>

                <div>
                    <label for="task-description" class="form-label">Description</label>
                    <textarea wire:model="taskDescription" 
                              id="task-description" 
                              rows="3" 
                              class="form-textarea"></textarea>
                </div>

                <div>
                    <label for="task-type" class="form-label">Type</label>
                    <select wire:model="taskType" 
                            id="task-type" 
                            class="form-select">
                        <option value="">Select Type</option>
                        @foreach ($taskTypes as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="due-date" class="form-label">Due Date</label>
                    <input type="date" 
                           wire:model="dueDate" 
                           id="due-date" 
                           class="form-input">
                </div>

                <div>
                    <label for="priority" class="form-label">Priority</label>
                    <select wire:model="priority" 
                            id="priority" 
                            class="form-select">
                        @foreach ($priorities as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" 
                        wire:click="$set('showTaskModal', false)" 
                        class="btn btn-secondary">
                    Cancel
                </button>
                <button type="button" 
                        wire:click="createTask" 
                        class="btn btn-primary">
                    Create Task
                </button>
            </div>
        </div>
    </div>
</div> 
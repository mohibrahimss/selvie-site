<div>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">Tasks</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Manage and track tasks for your team.</p>
            </div>
            @if(auth()->user()->hasTeamPermission($team, 'create'))
                <button wire:click="createTask" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Create Task
                </button>
            @endif
        </div>

        <!-- Filters -->
        <div class="px-4 py-3 border-t border-gray-200 sm:px-6 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
                <!-- Search -->
                <div class="md:col-span-2">
                    <label for="search" class="sr-only">Search</label>
                    <div class="relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="search" wire:model.debounce.300ms="search" id="search" class="focus:ring-primary focus:border-primary block w-full pl-10 sm:text-sm border-gray-300 rounded-md" placeholder="Search tasks...">
                    </div>
                </div>

                <!-- Status Filter -->
                <div>
                    <select wire:model="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md">
                        <option value="">All Status</option>
                        @foreach($statusOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Priority Filter -->
                <div>
                    <select wire:model="priority" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md">
                        <option value="">All Priorities</option>
                        @foreach($priorityOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Category Filter -->
                <div>
                    <select wire:model="category" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md">
                        <option value="">All Categories</option>
                        @foreach($categoryOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Assigned To Filter -->
                <div>
                    <select wire:model="assignedTo" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md">
                        <option value="">All Assignees</option>
                        @foreach($teamMembers as $member)
                            <option value="{{ $member->id }}">{{ $member->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Quick Filters -->
            <div class="flex space-x-4">
                <button wire:click="toggleFilter('overdue')" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary {{ $filters['overdue'] ? 'bg-primary text-white hover:bg-primary-hover' : '' }}">
                    Overdue
                </button>
                <button wire:click="toggleFilter('my_tasks')" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary {{ $filters['my_tasks'] ? 'bg-primary text-white hover:bg-primary-hover' : '' }}">
                    My Tasks
                </button>
                <button wire:click="toggleFilter('assigned_by_me')" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary {{ $filters['assigned_by_me'] ? 'bg-primary text-white hover:bg-primary-hover' : '' }}">
                    Assigned by Me
                </button>
            </div>
        </div>

        <!-- Tasks List -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('title')">
                            Title
                            @if($sortField === 'title')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Assigned To
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('due_date')">
                            Due Date
                            @if($sortField === 'due_date')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Priority
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($tasks as $task)
                        <tr class="hover:bg-gray-50 cursor-pointer" wire:click="showTask({{ $task->id }})">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $task->title }}</div>
                                <div class="text-sm text-gray-500">{{ $task->category }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $task->assignedTo->name }}</div>
                                <div class="text-sm text-gray-500">Assigned by {{ $task->assignedBy->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $task->due_date->format('M j, Y') }}</div>
                                <div class="text-sm text-gray-500">{{ $task->due_date->diffForHumans() }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $task->priority === 'low' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $task->priority === 'medium' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $task->priority === 'high' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $task->priority === 'urgent' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($task->priority) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $task->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $task->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $task->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $task->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($task->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click.stop="editTask({{ $task->id }})" class="text-primary hover:text-primary-hover">
                                    Edit
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                No tasks found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $tasks->links() }}
        </div>
    </div>

    <!-- Task Form Modal -->
    @if($showTaskForm)
        @livewire('school.task-form', ['team' => $team, 'task' => $selectedTask], key($selectedTask?->id ?? 'new'))
    @endif

    <!-- Task Details Modal -->
    @if($showTaskDetails && $selectedTask)
        <x-dialog-modal wire:model="showTaskDetails">
            <x-slot name="title">
                <div class="flex justify-between items-center">
                    <span>{{ $selectedTask->title }}</span>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                        {{ $selectedTask->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $selectedTask->status === 'in_progress' ? 'bg-blue-100 text-blue-800' : '' }}
                        {{ $selectedTask->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $selectedTask->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                        {{ ucfirst($selectedTask->status) }}
                    </span>
                </div>
            </x-slot>

            <x-slot name="content">
                <div class="space-y-6">
                    <!-- Task Details -->
                    <div>
                        <h4 class="text-sm font-medium text-gray-500">Description</h4>
                        <p class="mt-1 text-sm text-gray-900">{{ $selectedTask->description ?: 'No description provided.' }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Assigned To</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $selectedTask->assignedTo->name }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Assigned By</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $selectedTask->assignedBy->name }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Due Date</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $selectedTask->due_date->format('M j, Y') }}</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Priority</h4>
                            <p class="mt-1">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $selectedTask->priority === 'low' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $selectedTask->priority === 'medium' ? 'bg-blue-100 text-blue-800' : '' }}
                                    {{ $selectedTask->priority === 'high' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $selectedTask->priority === 'urgent' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ ucfirst($selectedTask->priority) }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Time Spent</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $selectedTask->time_spent }} hours</p>
                        </div>

                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Estimated Hours</h4>
                            <p class="mt-1 text-sm text-gray-900">{{ $selectedTask->estimated_hours ?? 'Not estimated' }}</p>
                        </div>
                    </div>

                    <!-- Attachments -->
                    @if($selectedTask->attachments->isNotEmpty())
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Attachments</h4>
                            <ul class="mt-2 divide-y divide-gray-200">
                                @foreach($selectedTask->attachments as $attachment)
                                    <li class="py-2 flex items-center justify-between">
                                        <div class="flex items-center">
                                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                                            </svg>
                                            <span class="ml-2 text-sm text-gray-900">{{ $attachment->name }}</span>
                                            <span class="ml-2 text-sm text-gray-500">({{ $attachment->size_for_humans }})</span>
                                        </div>
                                        <a href="{{ $attachment->url }}" target="_blank" class="text-primary hover:text-primary-hover text-sm font-medium">
                                            Download
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Comments -->
                    @if($selectedTask->comments->isNotEmpty())
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Comments</h4>
                            <ul class="mt-2 space-y-4">
                                @foreach($selectedTask->comments as $comment)
                                    <li class="bg-gray-50 rounded-lg p-4">
                                        <div class="flex space-x-3">
                                            <div class="flex-1">
                                                <div class="flex items-center justify-between">
                                                    <h3 class="text-sm font-medium text-gray-900">{{ $comment->user->name }}</h3>
                                                    <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                                                </div>
                                                <div class="mt-1 text-sm text-gray-700">
                                                    <p>{{ $comment->content }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </x-slot>

            <x-slot name="footer">
                <div class="flex justify-between w-full">
                    <div>
                        @if($selectedTask->status !== 'completed' && $selectedTask->assignedTo->id === auth()->id())
                            <x-button wire:click="markAsCompleted({{ $selectedTask->id }})" class="mr-3">
                                Mark as Completed
                            </x-button>
                        @endif
                    </div>
                    <div class="flex">
                        <x-secondary-button wire:click="hideTask" class="mr-3">
                            Close
                        </x-secondary-button>
                        <x-button wire:click="editTask({{ $selectedTask->id }})">
                            Edit Task
                        </x-button>
                    </div>
                </div>
            </x-slot>
        </x-dialog-modal>
    @endif
</div> 
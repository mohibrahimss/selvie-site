<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    <!-- Training Header -->
    <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
        <div>
            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $training->title }}</h3>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ $training->description }}</p>
        </div>
        <div class="flex space-x-4">
            @if($training->status === 'published' && !$enrollment)
                <button wire:click="enroll" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    Enroll Now
                </button>
            @endif

            @if(auth()->user()->hasTeamPermission($team, 'update'))
                <button wire:click="addModule" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Add Module
                </button>
            @endif
        </div>
    </div>

    <!-- Training Details -->
    <div class="border-t border-gray-200 px-4 py-5 sm:px-6">
        <dl class="grid grid-cols-1 gap-x-4 gap-y-8 sm:grid-cols-3">
            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">Category</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $training->category }}</dd>
            </div>

            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">Level</dt>
                <dd class="mt-1">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                        {{ $training->level === 'beginner' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $training->level === 'intermediate' ? 'bg-yellow-100 text-yellow-800' : '' }}
                        {{ $training->level === 'advanced' ? 'bg-red-100 text-red-800' : '' }}">
                        {{ ucfirst($training->level) }}
                    </span>
                </dd>
            </div>

            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">Status</dt>
                <dd class="mt-1">
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                        {{ $training->status === 'draft' ? 'bg-gray-100 text-gray-800' : '' }}
                        {{ $training->status === 'published' ? 'bg-green-100 text-green-800' : '' }}
                        {{ $training->status === 'archived' ? 'bg-red-100 text-red-800' : '' }}">
                        {{ ucfirst($training->status) }}
                    </span>
                </dd>
            </div>

            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">Created By</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $training->createdBy->name }}</dd>
            </div>

            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">Created At</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $training->created_at->format('M j, Y') }}</dd>
            </div>

            <div class="sm:col-span-1">
                <dt class="text-sm font-medium text-gray-500">Estimated Duration</dt>
                <dd class="mt-1 text-sm text-gray-900">{{ $training->estimated_duration }} minutes</dd>
            </div>

            @if($enrollment)
                <div class="sm:col-span-3">
                    <dt class="text-sm font-medium text-gray-500">Your Progress</dt>
                    <dd class="mt-1">
                        <div class="relative pt-1">
                            <div class="overflow-hidden h-2 text-xs flex rounded bg-gray-200">
                                <div class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center transition-all duration-300 {{ $enrollment->is_completed ? 'bg-green-500' : 'bg-primary' }}" style="width: {{ $enrollment->progress }}%"></div>
                            </div>
                            <div class="text-xs text-gray-500 mt-1">{{ $enrollment->progress }}% Complete</div>
                        </div>
                    </dd>
                </div>
            @endif
        </dl>
    </div>

    <!-- Training Modules -->
    <div class="border-t border-gray-200">
        <div class="px-4 py-5 sm:px-6">
            <h4 class="text-lg font-medium text-gray-900">Modules</h4>
            <p class="mt-1 text-sm text-gray-500">Complete all required modules to finish the training.</p>
        </div>

        <ul class="divide-y divide-gray-200">
            @forelse($training->modules as $module)
                <li class="px-4 py-4 sm:px-6 hover:bg-gray-50">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center">
                                @if($enrollment && $module->is_completed_by_user)
                                    <svg class="h-5 w-5 text-green-500 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @else
                                    <svg class="h-5 w-5 text-gray-400 mr-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                @endif

                                <div>
                                    <a href="{{ route('module.view', ['team' => $team, 'training' => $training, 'module' => $module]) }}" class="text-sm font-medium text-primary hover:text-primary-hover truncate">
                                        {{ $module->title }}
                                    </a>
                                    <div class="mt-1 flex items-center">
                                        <span class="text-sm text-gray-500">{{ $module->description }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="flex flex-col items-end">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    {{ ucfirst($module->type) }}
                                </span>
                                @if($module->is_required)
                                    <span class="mt-1 text-xs text-gray-500">Required</span>
                                @endif
                            </div>

                            @if(auth()->user()->hasTeamPermission($team, 'update'))
                                <div class="flex items-center space-x-2">
                                    <button wire:click="reorderModule({{ $module->id }}, 'up')" class="text-gray-400 hover:text-gray-500" {{ $loop->first ? 'disabled' : '' }}>
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                        </svg>
                                    </button>
                                    <button wire:click="reorderModule({{ $module->id }}, 'down')" class="text-gray-400 hover:text-gray-500" {{ $loop->last ? 'disabled' : '' }}>
                                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>
                                    <button wire:click="editModule({{ $module->id }})" class="text-primary hover:text-primary-hover">
                                        Edit
                                    </button>
                                    <button wire:click="deleteModule({{ $module->id }})" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this module?')">
                                        Delete
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                </li>
            @empty
                <li class="px-4 py-5 sm:px-6 text-center text-sm text-gray-500">
                    No modules found. {{ auth()->user()->hasTeamPermission($team, 'update') ? 'Click "Add Module" to create one.' : '' }}
                </li>
            @endforelse
        </ul>
    </div>

    <!-- Module Form Modal -->
    @if($showModuleForm)
        @livewire('school.module-form', ['training' => $training, 'module' => $selectedModule], key($selectedModule?->id ?? 'new'))
    @endif
</div> 
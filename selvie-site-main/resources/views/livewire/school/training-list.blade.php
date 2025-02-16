<div>
    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
            <div>
                <h3 class="text-lg leading-6 font-medium text-gray-900">Trainings</h3>
                <p class="mt-1 max-w-2xl text-sm text-gray-500">Manage and track training courses for your team.</p>
            </div>
            @if(auth()->user()->hasTeamPermission($team, 'create'))
                <button wire:click="createTraining" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary hover:bg-primary-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                    <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Create Training
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
                        <input type="search" wire:model.debounce.300ms="search" id="search" class="focus:ring-primary focus:border-primary block w-full pl-10 sm:text-sm border-gray-300 rounded-md" placeholder="Search trainings...">
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

                <!-- Category Filter -->
                <div>
                    <select wire:model="category" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md">
                        <option value="">All Categories</option>
                        @foreach($categoryOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Level Filter -->
                <div>
                    <select wire:model="level" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-primary focus:border-primary sm:text-sm rounded-md">
                        <option value="">All Levels</option>
                        @foreach($levelOptions as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Quick Filters -->
            <div class="flex space-x-4">
                <button wire:click="toggleFilter('required')" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary {{ $filters['required'] ? 'bg-primary text-white hover:bg-primary-hover' : '' }}">
                    Required
                </button>
                <button wire:click="toggleFilter('created_by_me')" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary {{ $filters['created_by_me'] ? 'bg-primary text-white hover:bg-primary-hover' : '' }}">
                    Created by Me
                </button>
                <button wire:click="toggleFilter('enrolled')" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary {{ $filters['enrolled'] ? 'bg-primary text-white hover:bg-primary-hover' : '' }}">
                    Enrolled
                </button>
                <button wire:click="toggleFilter('completed')" class="inline-flex items-center px-2.5 py-1.5 border border-gray-300 shadow-sm text-xs font-medium rounded text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary {{ $filters['completed'] ? 'bg-primary text-white hover:bg-primary-hover' : '' }}">
                    Completed
                </button>
            </div>
        </div>

        <!-- Trainings List -->
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
                            Category
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Level
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider cursor-pointer" wire:click="sortBy('created_at')">
                            Created
                            @if($sortField === 'created_at')
                                <span class="ml-1">{{ $sortDirection === 'asc' ? '↑' : '↓' }}</span>
                            @endif
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Progress
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($trainings as $training)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">
                                    <a href="{{ route('trainings.view', ['team' => $team, 'training' => $training]) }}" class="hover:text-primary">
                                        {{ $training->title }}
                                    </a>
                                </div>
                                <div class="text-sm text-gray-500">{{ Str::limit($training->description, 50) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    {{ $categoryOptions[$training->category] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $training->level === 'beginner' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $training->level === 'intermediate' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                    {{ $training->level === 'advanced' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ $levelOptions[$training->level] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $training->created_at->format('M j, Y') }}</div>
                                <div class="text-sm text-gray-500">by {{ $training->createdBy->name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $training->status === 'draft' ? 'bg-gray-100 text-gray-800' : '' }}
                                    {{ $training->status === 'published' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $training->status === 'archived' ? 'bg-red-100 text-red-800' : '' }}">
                                    {{ $statusOptions[$training->status] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="relative pt-1">
                                    <div class="overflow-hidden h-2 text-xs flex rounded bg-gray-200">
                                        <div class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-primary transition-all duration-300" style="width: {{ $training->progress_for_user }}%"></div>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1">{{ $training->progress_for_user }}% Complete</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    @if($training->status === 'published' && !$training->enrollments()->where('user_id', auth()->id())->exists())
                                        <button wire:click="enroll({{ $training->id }})" class="text-primary hover:text-primary-hover">
                                            Enroll
                                        </button>
                                    @endif

                                    @if(auth()->user()->hasTeamPermission($team, 'update'))
                                        <button wire:click="editTraining({{ $training->id }})" class="text-primary hover:text-primary-hover">
                                            Edit
                                        </button>

                                        @if($training->status === 'draft')
                                            <button wire:click="publish({{ $training->id }})" class="text-green-600 hover:text-green-900">
                                                Publish
                                            </button>
                                        @elseif($training->status === 'published')
                                            <button wire:click="unpublish({{ $training->id }})" class="text-yellow-600 hover:text-yellow-900">
                                                Unpublish
                                            </button>
                                        @endif

                                        @if($training->status !== 'archived')
                                            <button wire:click="archive({{ $training->id }})" class="text-red-600 hover:text-red-900">
                                                Archive
                                            </button>
                                        @endif
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                No trainings found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $trainings->links() }}
        </div>
    </div>

    <!-- Training Form Modal -->
    @if($showTrainingForm)
        @livewire('school.training-form', ['team' => $team, 'training' => $selectedTraining], key($selectedTraining?->id ?? 'new'))
    @endif
</div> 
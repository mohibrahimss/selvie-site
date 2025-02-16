<!-- Student List -->
<div class="mx-auto space-y-6 max-w-[1280px]">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-gradient">
            <div class="page-header-content">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="page-title">My Students</h1>
                        <p class="page-subtitle">Manage and track your student progress</p>
                    </div>
                    <div class="flex gap-3">
                        <button type="button" class="btn btn-secondary">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span>Export Data</span>
                        </button>
                        <button type="button" class="btn btn-primary">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            <span>Schedule Group Meeting</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filters -->
    <div class="card">
        <div class="card-body space-y-6">
            <!-- Basic Search -->
            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <div class="col-span-2">
                    <label for="search" class="form-label">Search Students</label>
                    <div class="relative">
                        <input type="text" 
                               wire:model.debounce.300ms="search" 
                               id="search" 
                               class="form-input pl-10" 
                               placeholder="Search by name or ID...">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="filter" class="form-label">Filter By</label>
                    <select wire:model="filter" 
                            id="filter" 
                            class="form-select">
                        <option value="all">All Students</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="needs_attention">Needs Attention</option>
                    </select>
                </div>
            </div>

            <!-- Advanced Filters -->
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-4">
                <div>
                    <label for="grade" class="form-label">Grade Level</label>
                    <select wire:model="gradeLevel" 
                            id="grade" 
                            class="form-select">
                        <option value="">All Grades</option>
                        <option value="9">9th Grade</option>
                        <option value="10">10th Grade</option>
                        <option value="11">11th Grade</option>
                        <option value="12">12th Grade</option>
                    </select>
                </div>

                <div>
                    <label for="school" class="form-label">School</label>
                    <select wire:model="school" 
                            id="school" 
                            class="form-select">
                        <option value="">All Schools</option>
                        <option value="washington">Washington High</option>
                        <option value="lincoln">Lincoln Elementary</option>
                    </select>
                </div>

                <div>
                    <label for="support" class="form-label">Support Type</label>
                    <select wire:model="supportType" 
                            id="support" 
                            class="form-select">
                        <option value="">All Types</option>
                        <option value="academic">Academic</option>
                        <option value="behavioral">Behavioral</option>
                        <option value="attendance">Attendance</option>
                    </select>
                </div>

                <div>
                    <label for="status" class="form-label">ISELP Status</label>
                    <select wire:model="iselpStatus" 
                            id="status" 
                            class="form-select">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="pending">Pending Review</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Student Grid -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @forelse($students as $student)
            <div class="card">
                <div class="card-body">
                    <div class="flex items-center">
                        <div class="avatar">
                            <img class="h-12 w-12 rounded-full" 
                                 src="{{ $student['avatar'] }}" 
                                 alt="{{ $student['name'] }} avatar">
                        </div>
                        <div class="ml-4 flex-1 min-w-0">
                            <h3 class="text-base font-semibold text-gray-900 truncate">
                                {{ $student['name'] }}
                            </h3>
                            <p class="text-sm text-gray-500">
                                ID: {{ $student['id'] }} • Grade {{ $student['grade'] }}
                            </p>
                        </div>
                        <div class="ml-4">
                            <span class="badge {{ 
                                $student['status'] === 'active' ? 'badge-success' : 
                                ($student['status'] === 'needs_attention' ? 'badge-warning' : 'badge-gray') 
                            }}">
                                {{ ucfirst($student['status']) }}
                            </span>
                        </div>
                    </div>
                    
                    <dl class="mt-4 grid grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">School</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $student['school'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Support Type</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $student['support_type'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Meeting</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $student['last_meeting'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">ISELP Status</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $student['iselp_status'] }}</dd>
                        </div>
                    </dl>

                    <div class="mt-6 flex justify-end gap-3">
                        <a href="{{ route('mentor.students.profile', ['studentId' => $student['id']]) }}" 
                           class="btn btn-secondary">
                            View Profile
                        </a>
                        <button type="button" 
                                wire:click="scheduleSession({{ $student['id'] }})" 
                                class="btn btn-primary">
                            Schedule Session
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No students found</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Try adjusting your search or filter criteria
                    </p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="flex items-center justify-between border-t border-gray-200 px-4 py-3 sm:px-6">
        <div class="flex flex-1 justify-between sm:hidden">
            <button wire:click="previousPage" 
                    @if($pagination['current_page'] === 1) disabled @endif
                    class="btn btn-secondary {{ $pagination['current_page'] === 1 ? 'opacity-50 cursor-not-allowed' : '' }}">
                Previous
            </button>
            <button wire:click="nextPage" 
                    @if(!$pagination['has_more_pages']) disabled @endif
                    class="btn btn-secondary {{ !$pagination['has_more_pages'] ? 'opacity-50 cursor-not-allowed' : '' }}">
                Next
            </button>
        </div>
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    Showing
                    <span class="font-medium">{{ $pagination['from'] }}</span>
                    to
                    <span class="font-medium">{{ $pagination['to'] }}</span>
                    of
                    <span class="font-medium">{{ $pagination['total'] }}</span>
                    results
                </p>
            </div>
            <div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                    <!-- Previous Page -->
                    <button wire:click="previousPage" 
                            @if($pagination['current_page'] === 1) disabled @endif
                            class="relative inline-flex items-center rounded-l-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 {{ $pagination['current_page'] === 1 ? 'opacity-50 cursor-not-allowed' : '' }}">
                        <span class="sr-only">Previous</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <!-- Page Numbers -->
                    @for($i = 1; $i <= $pagination['last_page']; $i++)
                        <button wire:click="gotoPage({{ $i }})" 
                                class="relative inline-flex items-center px-4 py-2 text-sm font-semibold {{ 
                                    $pagination['current_page'] === $i 
                                        ? 'z-10 bg-primary-600 text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-primary-600' 
                                        : 'text-gray-900 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 focus:outline-offset-0'
                                }}">
                            {{ $i }}
                        </button>
                    @endfor

                    <!-- Next Page -->
                    <button wire:click="nextPage" 
                            @if(!$pagination['has_more_pages']) disabled @endif
                            class="relative inline-flex items-center rounded-r-md px-2 py-2 text-gray-400 ring-1 ring-inset ring-gray-300 hover:bg-gray-50 {{ !$pagination['has_more_pages'] ? 'opacity-50 cursor-not-allowed' : '' }}">
                        <span class="sr-only">Next</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </nav>
            </div>
        </div>
    </div>
</div> 
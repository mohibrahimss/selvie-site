<!-- Training Center -->
<div class="mx-auto space-y-6 max-w-[1280px]">
    <!-- Page Header -->
    <div class="page-header">
        <div class="page-header-gradient">
            <div class="page-header-content">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="page-title">Training Center</h1>
                        <p class="page-subtitle">Access your required training and professional development courses</p>
                    </div>
                    <div class="relative w-72">
                        <input type="text" 
                               wire:model.debounce.300ms="search" 
                               class="form-input pl-10" 
                               placeholder="Search courses...">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Tabs -->
    <div class="card">
        <div class="card-header border-b border-gray-200 pb-0">
            <nav class="flex gap-6" aria-label="Tabs">
                @foreach ($categories as $key => $label)
                    <button wire:click="setActiveTab('{{ $key }}')" 
                            class="tab {{ $activeTab === $key ? 'tab-active' : '' }}">
                        {{ $label }}
                    </button>
                @endforeach
            </nav>
        </div>
    </div>

    <!-- Course Grid -->
    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        @foreach ($courses as $course)
            @if ($activeTab === 'all' || $course['category'] === $activeTab)
                <div class="card card-hover">
                    <div class="card-body">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-gray-900">{{ $course['title'] }}</h3>
                            <span class="badge {{ 
                                $course['status'] === 'completed' ? 'badge-success' :
                                ($course['status'] === 'in-progress' ? 'badge-warning' : 'badge-gray')
                            }}">
                                {{ ucfirst($course['status']) }}
                            </span>
                        </div>
                        <p class="mt-2 text-sm text-gray-500">{{ $course['description'] }}</p>
                        
                        <!-- Course Details -->
                        <div class="mt-4 flex items-center justify-between text-sm text-gray-500">
                            <div class="flex items-center">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $course['duration'] }}
                            </div>
                            <div class="flex items-center">
                                <svg class="flex-shrink-0 mr-1.5 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Due: {{ \Carbon\Carbon::parse($course['due_date'])->format('M j, Y') }}
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        <div class="mt-4">
                            <div class="flex items-center justify-between text-sm font-medium">
                                <span class="text-gray-900">Progress</span>
                                <span class="text-primary-600">{{ $course['progress'] }}%</span>
                            </div>
                            <div class="mt-2 relative">
                                <div class="overflow-hidden h-2 text-xs flex rounded bg-gray-200">
                                    <div style="width: {{ $course['progress'] }}%" 
                                         class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-primary-500"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-5 flex justify-end gap-3">
                            @if ($course['status'] === 'completed')
                                <button type="button" 
                                        wire:click="downloadCertificate({{ $course['id'] }})" 
                                        class="btn btn-success">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    <span>Certificate</span>
                                </button>
                            @endif
                            <button type="button" 
                                    wire:click="viewCourse({{ $course['id'] }})" 
                                    class="btn btn-primary">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <span>View Course</span>
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>

    <!-- Course Modal -->
    <div x-show="$wire.showCourseModal" 
         class="modal"
         x-cloak
         x-transition>
        <div class="modal-backdrop"></div>

        <div class="modal-content">
            @if ($selectedCourse)
                <div class="modal-header">
                    <h3 class="modal-title">{{ $selectedCourse['title'] }}</h3>
                    <button type="button" 
                            wire:click="$set('showCourseModal', false)" 
                            class="btn btn-icon">
                        <span class="sr-only">Close</span>
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div class="modal-body">
                    <p class="text-sm text-gray-500">{{ $selectedCourse['description'] }}</p>

                    <div class="mt-6">
                        <h4 class="text-sm font-medium text-gray-900">Course Modules</h4>
                        <ul class="mt-3 divide-y divide-gray-200">
                            @foreach ($selectedCourse['modules'] as $index => $module)
                                <li class="py-4">
                                    <div class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <span class="h-8 w-8 rounded-full bg-primary-50 text-primary-600 flex items-center justify-center font-medium">
                                                {{ $index + 1 }}
                                            </span>
                                            <p class="ml-4 text-sm font-medium text-gray-900">{{ $module['title'] }}</p>
                                        </div>
                                        <div class="ml-4 flex items-center gap-3">
                                            <span class="badge {{ 
                                                $module['status'] === 'completed' ? 'badge-success' :
                                                ($module['status'] === 'in-progress' ? 'badge-warning' : 'badge-gray')
                                            }}">
                                                {{ ucfirst($module['status']) }}
                                            </span>
                                            @if ($module['status'] !== 'completed')
                                                <button type="button" 
                                                        wire:click="startModule({{ $selectedCourse['id'] }}, {{ $index }})" 
                                                        class="btn btn-primary btn-sm">
                                                    {{ $module['status'] === 'in-progress' ? 'Continue' : 'Start' }}
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div> 
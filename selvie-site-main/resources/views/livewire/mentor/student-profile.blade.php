<!-- Student Profile -->
<div class="mx-auto space-y-6 max-w-[1280px]">
    <!-- Student Profile Header -->
    <div class="page-header">
        <div class="page-header-gradient">
            <div class="page-header-content">
                <div class="flex items-center">
                    <div class="avatar avatar-lg mr-6 ring-4 ring-white/20">
                        <img src="{{ $student['avatar'] }}" alt="{{ $student['name'] }}" class="h-full w-full object-cover">
                    </div>
                    <div>
                        <h2 class="page-title">{{ $student['name'] }}</h2>
                        <p class="page-subtitle">{{ $student['school'] }} • Grade {{ $student['grade'] }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="w-full">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Assignments -->
            <div class="stats-card">
                <div class="stats-card-icon bg-primary-100">
                    <svg class="h-6 w-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div class="stats-card-content">
                    <h4 class="stats-card-label">Assignments</h4>
                    <p class="stats-card-value">{{ $student['stats']['assignments'] }}</p>
                </div>
            </div>

            <!-- Progress -->
            <div class="stats-card">
                <div class="stats-card-icon bg-green-100">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="stats-card-content">
                    <h4 class="stats-card-label">Progress</h4>
                    <p class="stats-card-value">{{ $student['stats']['progress'] }}%</p>
                </div>
            </div>

            <!-- Hours -->
            <div class="stats-card">
                <div class="stats-card-icon bg-purple-100">
                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="stats-card-content">
                    <h4 class="stats-card-label">Hours Spent</h4>
                    <p class="stats-card-value">{{ $student['stats']['hours'] }}</p>
                </div>
            </div>

            <!-- Goals -->
            <div class="stats-card">
                <div class="stats-card-icon bg-yellow-100">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <div class="stats-card-content">
                    <h4 class="stats-card-label">Goals Met</h4>
                    <p class="stats-card-value">{{ $student['stats']['goals'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs -->
    <div class="card">
        <div class="tab-group">
            <nav class="flex px-6 -mb-px space-x-8">
                <button 
                    wire:click="setTab('overview')"
                    class="tab {{ $activeTab === 'overview' ? 'tab-active' : 'tab-inactive' }}">
                    Overview
                </button>
                <button 
                    wire:click="setTab('upload')"
                    class="tab {{ $activeTab === 'upload' ? 'tab-active' : 'tab-inactive' }}">
                    Upload Data
                </button>
                <button 
                    wire:click="setTab('iselp')"
                    class="tab {{ $activeTab === 'iselp' ? 'tab-active' : 'tab-inactive' }}">
                    ISELP
                </button>
                <button 
                    wire:click="setTab('chat')"
                    class="tab {{ $activeTab === 'chat' ? 'tab-active' : 'tab-inactive' }}">
                    Chat
                </button>
            </nav>
        </div>

        <!-- Tab Content -->
        <div class="p-6">
            @if($activeTab === 'overview')
                <div class="grid grid-cols-3 gap-6">
                    <!-- Student Information -->
                    <div class="col-span-2 space-y-6">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Student Information</h3>
                                <button wire:click="editStudentInfo" class="btn btn-secondary">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                    </svg>
                                    <span>Edit Information</span>
                                </button>
                            </div>
                            <div class="card-body">
                                <dl class="grid grid-cols-2 gap-x-4 gap-y-6">
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Student ID</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $student['id'] }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Date of Birth</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $student['dob'] }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Grade Level</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $student['grade'] }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">School</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $student['school'] }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Parent/Guardian</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $student['guardian'] }}</dd>
                                    </div>
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Contact</dt>
                                        <dd class="mt-1 text-sm text-gray-900">{{ $student['contact'] }}</dd>
                                    </div>
                                </dl>
                            </div>
                        </div>

                        <!-- Academic Progress -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Academic Progress</h3>
                            </div>
                            <div class="card-body">
                                <div class="space-y-4">
                                    @foreach($student['subjects'] as $subject)
                                    <div>
                                        <div class="flex items-center justify-between mb-1">
                                            <span class="text-sm font-medium text-gray-700">{{ $subject['name'] }}</span>
                                            <span class="text-sm font-medium text-gray-900">{{ $subject['progress'] }}%</span>
                                        </div>
                                        <div class="progress-bar">
                                            <div class="progress-bar-fill" style="width: {{ $subject['progress'] }}%"></div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="space-y-6">
                        <!-- Upcoming Sessions -->
                        <div class="card card-hover">
                            <div class="card-header">
                                <h3 class="card-title">Upcoming Sessions</h3>
                            </div>
                            <div class="card-body">
                                <div class="space-y-4">
                                    @foreach($student['sessions'] as $session)
                                    <div class="flex items-center p-3 rounded-lg hover:bg-gray-50 transition-colors">
                                        <div class="flex-shrink-0">
                                            <div class="rounded-lg bg-primary-50 p-3">
                                                <svg class="h-6 w-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <h4 class="text-sm font-medium text-gray-900">{{ $session['title'] }}</h4>
                                            <p class="text-sm text-gray-500">{{ $session['date'] }} • {{ $session['time'] }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Recent Activity -->
                        <div class="card card-hover">
                            <div class="card-header">
                                <h3 class="card-title">Recent Activity</h3>
                            </div>
                            <div class="card-body">
                                <div class="space-y-4">
                                    @foreach($student['activities'] as $activity)
                                    <div class="flex space-x-3">
                                        <div class="flex-shrink-0">
                                            <div class="h-8 w-8 rounded-lg bg-{{ $activity['color'] }}-50 flex items-center justify-center">
                                                <svg class="h-5 w-5 text-{{ $activity['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    {!! $activity['icon'] !!}
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="min-w-0 flex-1">
                                            <p class="text-sm text-gray-900">{{ $activity['description'] }}</p>
                                            <p class="text-sm text-gray-500">{{ $activity['time'] }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($activeTab === 'upload')
                <div class="space-y-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Upload Student Data</h3>
                        </div>
                        <div class="card-body">
                            <div class="space-y-6">
                                <div>
                                    <label class="form-label">Academic Records</label>
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-primary-500 transition-colors">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="academic-records" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                                    <span>Upload files</span>
                                                    <input id="academic-records" wire:model="academicRecords" type="file" class="sr-only" multiple>
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">PDF, DOC up to 10MB</p>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <label class="form-label">Assessment Results</label>
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-primary-500 transition-colors">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600">
                                                <label for="assessment-results" class="relative cursor-pointer bg-white rounded-md font-medium text-primary-600 hover:text-primary-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-primary-500">
                                                    <span>Upload files</span>
                                                    <input id="assessment-results" wire:model="assessmentResults" type="file" class="sr-only" multiple>
                                                </label>
                                                <p class="pl-1">or drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">PDF, DOC up to 10MB</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex justify-end">
                                    <button type="button" wire:click="uploadFiles" class="btn btn-primary">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                        </svg>
                                        <span>Upload Files</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($activeTab === 'iselp')
                <div class="space-y-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">ISELP Management</h3>
                            <button wire:click="generateISELP" class="btn btn-primary">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                                <span>Generate ISELP</span>
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="space-y-6">
                                <!-- ISELP Status -->
                                <div class="alert alert-warning">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <h3 class="text-sm font-medium text-yellow-800">ISELP Status: Pending Update</h3>
                                            <div class="mt-2 text-sm text-yellow-700">
                                                <p>The current ISELP needs to be updated with recent assessment data.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- ISELP History -->
                                <div>
                                    <h4 class="text-lg font-medium text-gray-900 mb-4">ISELP History</h4>
                                    <div class="space-y-4">
                                        @foreach($student['iselp_history'] as $iselp)
                                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                            <div>
                                                <p class="text-sm font-medium text-gray-900">{{ $iselp['date'] }}</p>
                                                <p class="text-sm text-gray-500">Version {{ $iselp['version'] }}</p>
                                            </div>
                                            <div class="flex space-x-2">
                                                <button wire:click="viewISELP('{{ $iselp['id'] }}')" class="btn btn-secondary">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    <span>View</span>
                                                </button>
                                                <button wire:click="downloadISELP('{{ $iselp['id'] }}')" class="btn btn-secondary">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                    </svg>
                                                    <span>Download</span>
                                                </button>
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if($activeTab === 'chat')
                <div class="card bg-gray-50 border" style="height: 600px;">
                    <div class="card-header bg-white">
                        <h3 class="card-title">Chat Support</h3>
                    </div>
                    <div class="flex flex-col h-full">
                        <!-- Chat Messages -->
                        <div class="flex-1 p-4 overflow-y-auto scrollbar-thin" id="chat-messages">
                            <div class="space-y-4">
                                @foreach($messages as $message)
                                <div class="flex {{ $message['sender'] === 'bot' ? 'justify-start' : 'justify-end' }}">
                                    <div class="chat-message {{ $message['sender'] === 'bot' ? 'chat-message-bot' : 'chat-message-user' }}">
                                        <p class="text-sm">{{ $message['content'] }}</p>
                                        <p class="chat-message-time {{ $message['sender'] === 'bot' ? 'chat-message-time-bot' : 'chat-message-time-user' }}">
                                            {{ $message['time'] }}
                                        </p>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Chat Input -->
                        <div class="border-t bg-white p-4">
                            <form wire:submit.prevent="sendMessage" class="flex space-x-4">
                                <div class="flex-1">
                                    <input 
                                        type="text" 
                                        wire:model="newMessage" 
                                        class="form-input" 
                                        placeholder="Type your message..."
                                        autocomplete="off"
                                    >
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                    </svg>
                                    <span>Send</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div> 
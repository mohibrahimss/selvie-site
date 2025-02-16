<!-- Mentor Dashboard -->
<div class="mx-auto space-y-6 max-w-[1280px]">
    <!-- Welcome Header -->
    <div class="page-header">
        <div class="page-header-gradient">
            <div class="page-header-content">
                <h1 class="page-title">Welcome back, {{ auth()->user()->name }}!</h1>
                <p class="page-subtitle">Here's what's happening with your students today.</p>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="w-full">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Active Students -->
            <div class="stats-card">
                <div class="stats-card-icon bg-primary-100">
                    <svg class="h-6 w-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="stats-card-content">
                    <h4 class="stats-card-label">Active Students</h4>
                    <p class="stats-card-value">{{ $stats['activeStudents'] }}</p>
                </div>
            </div>

            <!-- Pending Tasks -->
            <div class="stats-card">
                <div class="stats-card-icon bg-yellow-100">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
                <div class="stats-card-content">
                    <h4 class="stats-card-label">Pending Tasks</h4>
                    <p class="stats-card-value">{{ $stats['pendingTasks'] }}</p>
                </div>
            </div>

            <!-- Today's Meetings -->
            <div class="stats-card">
                <div class="stats-card-icon bg-green-100">
                    <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <div class="stats-card-content">
                    <h4 class="stats-card-label">Today's Meetings</h4>
                    <p class="stats-card-value">{{ $stats['todayMeetings'] }}</p>
                </div>
            </div>

            <!-- Messages -->
            <div class="stats-card">
                <div class="stats-card-icon bg-purple-100">
                    <svg class="h-6 w-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                </div>
                <div class="stats-card-content">
                    <h4 class="stats-card-label">Unread Messages</h4>
                    <p class="stats-card-value">{{ $stats['unreadMessages'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Upcoming Meetings -->
        <div class="lg:col-span-2">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Upcoming Meetings</h2>
                    <button class="btn btn-secondary">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Schedule Meeting</span>
                    </button>
                </div>
                <div class="card-body">
                    <div class="space-y-4">
                        @forelse($upcomingMeetings as $meeting)
                            <div class="flex items-center p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                                <div class="flex-shrink-0">
                                    <div class="rounded-lg bg-primary-50 p-3">
                                        <svg class="h-6 w-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                </div>
                                <div class="ml-4 flex-1">
                                    <h3 class="text-sm font-medium text-gray-900">{{ $meeting['title'] }}</h3>
                                    <div class="mt-1 flex items-center text-sm text-gray-500">
                                        <span>{{ $meeting['time'] }}</span>
                                        <span class="mx-2">•</span>
                                        <span>{{ $meeting['duration'] }}</span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $meeting['status'] === 'confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ ucfirst($meeting['status']) }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4 text-gray-500">
                                No upcoming meetings scheduled
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="lg:col-span-1">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Recent Activity</h2>
                </div>
                <div class="card-body">
                    <div class="flow-root">
                        <ul class="-mb-8">
                            @foreach($recentActivity as $activity)
                                <li>
                                    <div class="relative pb-8">
                                        @if(!$loop->last)
                                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white bg-{{ $activity['color'] }}-100">
                                                    <svg class="h-5 w-5 text-{{ $activity['color'] }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        {!! $activity['icon'] !!}
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm text-gray-900">{{ $activity['description'] }}</p>
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                    <time datetime="{{ $activity['time'] }}">{{ $activity['time'] }}</time>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="mt-6 text-center">
                        <button type="button" class="btn btn-secondary w-full justify-center">
                            View All Activity
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
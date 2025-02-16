<div>
    <!-- Calendar Header -->
    <div class="page-header">
        <div class="page-header-gradient">
            <div class="page-header-content">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="page-title">Calendar</h2>
                        <p class="page-subtitle">Manage your meetings and schedule</p>
                    </div>
                    <button type="button" wire:click="showCreateMeetingModal" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-indigo-700 bg-white hover:bg-indigo-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-150 ease-in-out shadow-sm">
                        <svg class="-ml-1 mr-3 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Schedule Meeting
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Calendar Container -->
    <div class="card overflow-hidden">
        <div wire:ignore>
            <div id="calendar" class="fc fc-media-screen fc-direction-ltr"></div>
        </div>
    </div>

    <!-- Upcoming Meetings -->
    <div class="mt-8 card">
        <div class="card-header">
            <h3 class="card-title">Upcoming Meetings</h3>
        </div>
        <div class="p-6 space-y-6">
            @foreach ($meetings as $meeting)
                <div class="bg-white border border-gray-100 rounded-xl p-4 hover:border-indigo-100 hover:shadow-md transition-all duration-200">
                    <div class="sm:flex sm:items-center sm:justify-between">
                        <div class="mb-4 sm:mb-0">
                            <h4 class="text-lg font-semibold text-gray-900">{{ $meeting['title'] }}</h4>
                            <div class="mt-1 flex items-center text-sm text-gray-500">
                                <svg class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ \Carbon\Carbon::parse($meeting['start'])->format('M j, Y g:i A') }} - 
                                {{ \Carbon\Carbon::parse($meeting['end'])->format('g:i A') }}
                            </div>
                            <div class="mt-1 flex items-center text-sm text-gray-500">
                                <svg class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                {{ $meeting['location'] }}
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-2">
                            @if ($meeting['location'] === 'virtual')
                                <button type="button" wire:click="joinMeeting({{ $meeting['id'] }})" class="btn btn-primary">
                                    Join Meeting
                                </button>
                            @endif
                            <button type="button" wire:click="rescheduleMeeting({{ $meeting['id'] }})" class="btn btn-secondary">
                                Reschedule
                            </button>
                            <button type="button" wire:click="cancelMeeting({{ $meeting['id'] }})" class="btn btn-secondary text-red-600 hover:text-red-700 hover:border-red-600">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Create Meeting Modal -->
    <div x-show="$wire.showMeetingModal" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-xl px-4 pt-5 pb-4 text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full sm:p-6">
                <div>
                    <h3 class="text-xl font-bold text-gray-900 mb-6">Schedule Meeting</h3>
                    
                    <div class="space-y-6">
                        <div>
                            <label for="meeting-title" class="block text-sm font-medium text-gray-700">Title</label>
                            <input type="text" wire:model="meetingTitle" id="meeting-title" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="meeting-type" class="block text-sm font-medium text-gray-700">Type</label>
                            <select wire:model="meetingType" id="meeting-type" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="">Select Type</option>
                                @foreach ($meetingTypes as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="meeting-date" class="block text-sm font-medium text-gray-700">Date</label>
                                <input type="date" wire:model="meetingDate" id="meeting-date" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label for="meeting-time" class="block text-sm font-medium text-gray-700">Time</label>
                                <input type="time" wire:model="meetingTime" id="meeting-time" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <div>
                            <label for="meeting-duration" class="block text-sm font-medium text-gray-700">Duration (minutes)</label>
                            <input type="number" wire:model="meetingDuration" id="meeting-duration" min="15" max="180" step="15" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        </div>

                        <div>
                            <label for="meeting-location" class="block text-sm font-medium text-gray-700">Location</label>
                            <select wire:model="meetingLocation" id="meeting-location" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                <option value="virtual">Virtual Meeting</option>
                                <option value="school">School</option>
                                <option value="office">Office</option>
                            </select>
                        </div>

                        <div>
                            <label for="meeting-agenda" class="block text-sm font-medium text-gray-700">Agenda</label>
                            <textarea wire:model="meetingAgenda" id="meeting-agenda" rows="3" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                        </div>
                    </div>
                </div>

                <div class="mt-8 sm:flex sm:flex-row-reverse sm:gap-3">
                    <button type="button" wire:click="createMeeting" class="btn btn-primary w-full sm:w-auto">
                        Schedule Meeting
                    </button>
                    <button type="button" wire:click="$set('showMeetingModal', false)" class="mt-3 sm:mt-0 btn btn-secondary w-full sm:w-auto">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            plugins: ['dayGrid', 'timeGrid', 'list', 'interaction'],
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
            },
            height: 'auto',
            navLinks: true,
            editable: true,
            selectable: true,
            selectMirror: true,
            dayMaxEvents: true,
            events: {!! json_encode($meetings->map(function($meeting) {
                return [
                    'id' => $meeting['id'],
                    'title' => $meeting['title'],
                    'start' => $meeting['start'],
                    'end' => $meeting['end'],
                    'location' => $meeting['location'],
                    'backgroundColor' => $meeting['location'] === 'virtual' ? '#4F46E5' : '#059669',
                    'borderColor' => $meeting['location'] === 'virtual' ? '#4338CA' : '#047857'
                ];
            })) !!},
            select: function(info) {
                @this.showCreateMeetingModal();
                @this.set('meetingDate', info.startStr.split('T')[0]);
                @this.set('meetingTime', info.startStr.split('T')[1]?.substring(0, 5) || '09:00');
            },
            eventClick: function(info) {
                // Handle event click - can be used to show event details or edit modal
                @this.emit('meetingSelected', info.event.id);
            },
            eventDrop: function(info) {
                // Handle event drag and drop
                @this.emit('meetingMoved', {
                    id: info.event.id,
                    start: info.event.startStr,
                    end: info.event.endStr
                });
            },
            eventResize: function(info) {
                // Handle event duration resize
                @this.emit('meetingResized', {
                    id: info.event.id,
                    start: info.event.startStr,
                    end: info.event.endStr
                });
            }
        });
        
        calendar.render();

        // Listen for Livewire events to update calendar
        Livewire.on('refreshCalendar', () => {
            calendar.refetchEvents();
        });
    });

    // Make meetings data available globally
    window.meetings = {!! json_encode($meetings->map(function($meeting) {
        return [
            'id' => $meeting['id'],
            'title' => $meeting['title'],
            'start' => $meeting['start'],
            'end' => $meeting['end'],
            'location' => $meeting['location'],
            'backgroundColor' => $meeting['location'] === 'virtual' ? '#4F46E5' : '#059669',
            'borderColor' => $meeting['location'] === 'virtual' ? '#4338CA' : '#047857'
        ];
    })) !!};
</script>
@endpush

@push('styles')
<style>
    .fc {
        --fc-border-color: theme('colors.gray.200');
        --fc-button-bg-color: theme('colors.white');
        --fc-button-border-color: theme('colors.gray.300');
        --fc-button-text-color: theme('colors.gray.700');
        --fc-button-hover-bg-color: theme('colors.gray.50');
        --fc-button-hover-border-color: theme('colors.gray.400');
        --fc-button-active-bg-color: theme('colors.indigo.500');
        --fc-button-active-border-color: theme('colors.indigo.600');
        --fc-button-active-text-color: theme('colors.white');
        --fc-event-bg-color: theme('colors.indigo.600');
        --fc-event-border-color: theme('colors.indigo.700');
        --fc-today-bg-color: theme('colors.indigo.50');
    }

    .fc .fc-button {
        @apply font-medium text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500;
    }

    .fc .fc-toolbar-title {
        @apply text-xl font-bold text-gray-900;
    }

    .fc .fc-event {
        @apply rounded-lg shadow-sm cursor-pointer;
    }

    .fc .fc-daygrid-day.fc-day-today {
        @apply bg-indigo-50 font-semibold;
    }

    .fc .fc-col-header-cell {
        @apply py-3 bg-gray-50 font-semibold text-gray-900;
    }
</style>
@endpush 
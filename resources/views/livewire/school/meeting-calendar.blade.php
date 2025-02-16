<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meeting Calendar') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Calendar Container -->
                <div class="mb-4">
                    <div id="calendar"></div>
                </div>

                <!-- Meeting Form Modal -->
                @if($showMeetingForm)
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity">
                        <div class="fixed inset-0 z-10 overflow-y-auto">
                            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                                <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                                    @livewire('school.meeting-form', [
                                        'team' => $team,
                                        'meeting' => $selectedMeeting
                                    ])
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Meeting Details Modal -->
                @if($showMeetingDetails && $selectedMeeting)
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity">
                        <div class="fixed inset-0 z-10 overflow-y-auto">
                            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                                <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                                    <div class="absolute right-0 top-0 pr-4 pt-4">
                                        <button wire:click="hideMeetingDetails" type="button" class="rounded-md bg-white text-gray-400 hover:text-gray-500">
                                            <span class="sr-only">Close</span>
                                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="sm:flex sm:items-start">
                                        <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                            <h3 class="text-lg font-semibold leading-6 text-gray-900">
                                                {{ $selectedMeeting->title }}
                                            </h3>
                                            <div class="mt-4 space-y-3">
                                                <p class="text-sm text-gray-500">
                                                    <span class="font-medium">Mentor:</span> {{ $selectedMeeting->mentor->name }}
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    <span class="font-medium">Student:</span> {{ $selectedMeeting->student->name }}
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    <span class="font-medium">Start:</span> {{ $selectedMeeting->start_time->format('M j, Y g:i A') }}
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    <span class="font-medium">End:</span> {{ $selectedMeeting->end_time->format('M j, Y g:i A') }}
                                                </p>
                                                <p class="text-sm text-gray-500">
                                                    <span class="font-medium">Status:</span> {{ ucfirst($selectedMeeting->status) }}
                                                </p>
                                                @if($selectedMeeting->description)
                                                    <p class="text-sm text-gray-500">
                                                        <span class="font-medium">Description:</span><br>
                                                        {{ $selectedMeeting->description }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', function () {
            const calendarEl = document.getElementById('calendar');
            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: '{{ $currentView }}',
                initialDate: '{{ $currentDate }}',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                events: {!! json_encode($meetings) !!},
                editable: true,
                selectable: true,
                selectMirror: true,
                dayMaxEvents: true,
                select: function() {
                    Livewire.dispatch('createMeeting');
                },
                eventClick: function(info) {
                    Livewire.dispatch('showMeetingDetails', info.event.id);
                },
                datesSet: function(info) {
                    Livewire.dispatch('loadMeetings', 
                        info.start.toISOString().split('T')[0],
                        info.end.toISOString().split('T')[0]
                    );
                },
                viewDidMount: function(info) {
                    Livewire.dispatch('updateView', info.view.type);
                }
            });
            calendar.render();

            Livewire.on('refreshCalendar', () => {
                calendar.refetchEvents();
            });
        });
    </script>
    @endpush
</div> 
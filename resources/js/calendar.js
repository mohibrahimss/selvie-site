// Import FullCalendar Core and Plugins
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
import interactionPlugin from '@fullcalendar/interaction';

let calendar = null;

function initializeCalendar() {
    const calendarEl = document.getElementById('calendar');
    if (calendarEl && !calendar) {
        calendar = new Calendar(calendarEl, {
            plugins: [dayGridPlugin, timeGridPlugin, listPlugin, interactionPlugin],
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
            events: window.meetings || [],
            select: function(info) {
                // Handle date selection
                const livewire = window.Livewire.find(
                    document.getElementById('calendar').closest('[wire\\:id]').getAttribute('wire:id')
                );
                
                livewire.showCreateMeetingModal();
                livewire.set('meetingDate', info.startStr.split('T')[0]);
                livewire.set('meetingTime', info.startStr.split('T')[1]?.substring(0, 5) || '09:00');
            },
            eventClick: function(info) {
                // Handle event click
                const livewire = window.Livewire.find(
                    document.getElementById('calendar').closest('[wire\\:id]').getAttribute('wire:id')
                );
                
                livewire.dispatch('meetingSelected', info.event.id);
            },
            eventDrop: function(info) {
                // Handle event drag and drop
                const livewire = window.Livewire.find(
                    document.getElementById('calendar').closest('[wire\\:id]').getAttribute('wire:id')
                );
                
                livewire.dispatch('meetingMoved', {
                    id: info.event.id,
                    start: info.event.startStr,
                    end: info.event.endStr
                });
            },
            eventResize: function(info) {
                // Handle event resize
                const livewire = window.Livewire.find(
                    document.getElementById('calendar').closest('[wire\\:id]').getAttribute('wire:id')
                );
                
                livewire.dispatch('meetingResized', {
                    id: info.event.id,
                    start: info.event.startStr,
                    end: info.event.endStr
                });
            }
        });
        
        calendar.render();

        // Listen for Livewire events to update calendar
        window.Livewire.on('refreshCalendar', () => {
            calendar.refetchEvents();
        });
    }
}

// Initialize calendar when navigating to a page with calendar
document.addEventListener('livewire:navigated', initializeCalendar);

// Also initialize on DOMContentLoaded for the first load
document.addEventListener('DOMContentLoaded', initializeCalendar); 
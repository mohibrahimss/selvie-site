<?php

namespace App\Console\Commands;

use App\Models\Meeting;
use App\Notifications\MeetingReminder;
use Carbon\Carbon;
use Illuminate\Console\Command;

class SendMeetingReminders extends Command
{
    protected $signature = 'meetings:send-reminders';
    protected $description = 'Send reminders for upcoming meetings';

    public function handle()
    {
        $this->info('Sending meeting reminders...');

        // Reminder intervals in minutes
        $intervals = [60, 15]; // 1 hour and 15 minutes before

        foreach ($intervals as $minutes) {
            $this->sendRemindersForInterval($minutes);
        }

        $this->info('Meeting reminders sent successfully!');
    }

    protected function sendRemindersForInterval($minutes)
    {
        $start = Carbon::now()->addMinutes($minutes)->startOfMinute();
        $end = $start->copy()->endOfMinute();

        $meetings = Meeting::where('status', 'scheduled')
            ->whereBetween('start_time', [$start, $end])
            ->with(['mentor', 'student'])
            ->get();

        foreach ($meetings as $meeting) {
            // Send to mentor
            $meeting->mentor->notify(new MeetingReminder($meeting, $minutes));

            // Send to student
            $meeting->student->notify(new MeetingReminder($meeting, $minutes));

            $this->info("Sent {$minutes}-minute reminder for meeting: {$meeting->title}");
        }
    }
} 
<?php

namespace App\Notifications;

use App\Models\Meeting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MeetingReminder extends Notification implements ShouldQueue
{
    use Queueable;

    protected $meeting;
    protected $minutesUntilMeeting;

    public function __construct(Meeting $meeting, int $minutesUntilMeeting)
    {
        $this->meeting = $meeting;
        $this->minutesUntilMeeting = $minutesUntilMeeting;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = url('/meetings/' . $this->meeting->id);
        $timeUntil = $this->minutesUntilMeeting;
        $timeDescription = $timeUntil === 60 ? '1 hour' : "$timeUntil minutes";

        return (new MailMessage)
            ->subject("Meeting Reminder: {$this->meeting->title} in {$timeDescription}")
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line("This is a reminder that you have a meeting in {$timeDescription}.")
            ->line('Meeting Details:')
            ->line('Title: ' . $this->meeting->title)
            ->line('Date: ' . $this->meeting->start_time->format('l, F j, Y'))
            ->line('Time: ' . $this->meeting->start_time->format('g:i A') . ' - ' . $this->meeting->end_time->format('g:i A'))
            ->line('With: ' . ($notifiable->id === $this->meeting->student_id ? $this->meeting->mentor->name : $this->meeting->student->name))
            ->when($this->meeting->meeting_link, function ($message) {
                return $message->line('Meeting Link: ' . $this->meeting->meeting_link);
            })
            ->action('View Meeting Details', $url)
            ->line('Please make sure to join the meeting on time.');
    }

    public function toArray($notifiable)
    {
        return [
            'meeting_id' => $this->meeting->id,
            'title' => $this->meeting->title,
            'start_time' => $this->meeting->start_time,
            'minutes_until_meeting' => $this->minutesUntilMeeting,
        ];
    }
} 
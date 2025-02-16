<?php

namespace App\Notifications;

use App\Models\Meeting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MeetingScheduled extends Notification implements ShouldQueue
{
    use Queueable;

    protected $meeting;

    public function __construct(Meeting $meeting)
    {
        $this->meeting = $meeting;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = url('/meetings/' . $this->meeting->id);

        return (new MailMessage)
            ->subject('New Meeting Scheduled')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('A new meeting has been scheduled.')
            ->line('Title: ' . $this->meeting->title)
            ->line('Date: ' . $this->meeting->start_time->format('l, F j, Y'))
            ->line('Time: ' . $this->meeting->start_time->format('g:i A') . ' - ' . $this->meeting->end_time->format('g:i A'))
            ->line('With: ' . ($notifiable->id === $this->meeting->student_id ? $this->meeting->mentor->name : $this->meeting->student->name))
            ->action('View Meeting Details', $url)
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'meeting_id' => $this->meeting->id,
            'title' => $this->meeting->title,
            'start_time' => $this->meeting->start_time,
            'end_time' => $this->meeting->end_time,
        ];
    }
} 
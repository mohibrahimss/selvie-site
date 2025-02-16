<?php

namespace App\Notifications;

use App\Models\Meeting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MeetingUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $meeting;
    protected $changes;

    public function __construct(Meeting $meeting, array $changes)
    {
        $this->meeting = $meeting;
        $this->changes = $changes;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = url('/meetings/' . $this->meeting->id);
        $message = (new MailMessage)
            ->subject('Meeting Details Updated')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('The following meeting details have been updated:')
            ->line('Title: ' . $this->meeting->title);

        // Add changed fields to the message
        foreach ($this->changes as $field => $newValue) {
            if ($field === 'start_time') {
                $message->line('New Date/Time: ' . $this->meeting->start_time->format('l, F j, Y g:i A'));
            } elseif ($field === 'end_time') {
                $message->line('New End Time: ' . $this->meeting->end_time->format('g:i A'));
            } elseif ($field === 'status') {
                $message->line('New Status: ' . ucfirst($newValue));
            } else {
                $message->line("New $field: $newValue");
            }
        }

        return $message
            ->action('View Meeting Details', $url)
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'meeting_id' => $this->meeting->id,
            'title' => $this->meeting->title,
            'changes' => $this->changes,
        ];
    }
} 
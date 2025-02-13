<?php

namespace App\Mail;

use App\Models\EventReminder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventReminderMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public EventReminder $event;

    public function __construct(EventReminder $event)
    {
        $this->event = $event;
    }

    public function build()
    {
        return $this->subject("Reminder: {$this->event->title}")
            ->view('emails.event_reminder')
            ->with(['event' => $this->event]);
    }
}

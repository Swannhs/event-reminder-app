<?php

namespace App\Jobs;

use App\Mail\EventReminderMail;
use App\Models\EventReminder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEventReminderJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public EventReminder $event;

    public function __construct(EventReminder $event)
    {
        $this->event = $event;
    }

    public function handle()
    {
        Log::info("Sending reminder email for event: {$this->event->title}");
        if ($this->event->reminder_email) {
            Mail::to($this->event->reminder_email)->send(new EventReminderMail($this->event));
        }
    }
}

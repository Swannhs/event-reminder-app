<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Models\EventReminder;
use App\Jobs\SendEventReminderJob;

Artisan::command('schedule:send-reminders', function () {
    $events = EventReminder::where('date_time', '<=', now()->addMinutes(5))
        ->where('status', 'upcoming')
        ->get();

    foreach ($events as $event) {
        dispatch(new SendEventReminderJob($event));
    }

    $this->info('Reminder emails dispatched!');
})->purpose('Send scheduled event reminder emails');

Schedule::command('schedule:send-reminders')->everyMinute();

<?php

namespace App\Services;

use App\Data\EventReminderRequestData;
use App\Data\EventReminderResponseData;
use App\Models\EventReminder;
use Illuminate\Database\Eloquent\Collection;

class EventReminderService
{
    public function getAllEvents(): Collection
    {
        return EventReminder::all()->map(fn($event) => EventReminderResponseData::fromModel($event));
    }

    public function createEvent(EventReminderRequestData $data): EventReminderResponseData
    {
        $event = EventReminder::create([
            'event_id' => $this->generateEventId(),
            'title' => $data->title,
            'description' => $data->description,
            'date_time' => $data->date_time,
            'status' => $data->status,
            'reminder_email' => $data->reminder_email
        ]);

        return EventReminderResponseData::fromModel($event);
    }

    public function getEventById(int $id): EventReminderResponseData
    {
        return EventReminderResponseData::fromModel(EventReminder::findOrFail($id));
    }

    public function updateEvent(int $id, EventReminderRequestData $data): EventReminderResponseData
    {
        $event = EventReminder::findOrFail($id);
        $event->update([
            'title' => $data->title,
            'description' => $data->description,
            'date_time' => $data->date_time,
            'status' => $data->status,
            'reminder_email' => $data->reminder_email
        ]);

        return EventReminderResponseData::fromModel($event);
    }

    public function deleteEvent(int $id): bool
    {
        return EventReminder::findOrFail($id)->delete();
    }

    private function generateEventId(): string
    {
        return 'EVT-' . strtoupper(uniqid());
    }
}

<?php

namespace App\Services;

use App\Data\EventReminderRequestData;
use App\Data\EventReminderResponseData;
use App\Models\EventReminder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EventReminderService
{
    public function getAllEvents(int $perPage = 9): LengthAwarePaginator
    {
        return EventReminder::paginate($perPage);
    }

    public function createEvent(EventReminderRequestData $data): EventReminderResponseData
    {
        $event = EventReminder::create([
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

    public function updateEvent(int $id, EventReminderRequestData $data): EventReminder
    {
        $event = EventReminder::findOrFail($id);

        $event->update([
            'title' => $data->title,
            'description' => $data->description ?? $event->description,
            'date_time' => $data->date_time ?? $event->date_time,
            'status' => $data->status,
            'reminder_email' => $data->reminder_email ?? $event->reminder_email,
        ]);

        return $event;
    }

    public function deleteEvent(int $id): bool
    {
        return EventReminder::findOrFail($id)->delete();
    }
}

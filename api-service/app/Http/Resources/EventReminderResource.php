<?php

namespace App\Http\Resources;

use App\Data\EventReminderResponseData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EventReminderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $event = EventReminderResponseData::fromModel($this->resource);

        return [
            'id' => $event->id,
            'event_id' => $event->event_id,
            'title' => $event->title,
            'description' => $event->description,
            'date_time' => $event->date_time->toDateTimeString(),
            'status' => $event->status,
            'reminder_email' => $event->reminder_email,
            'created_at' => $event->created_at->toDateTimeString(),
            'updated_at' => $event->updated_at->toDateTimeString(),
        ];
    }
}

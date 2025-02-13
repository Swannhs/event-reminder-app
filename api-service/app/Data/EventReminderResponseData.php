<?php

namespace App\Data;

use Carbon\Carbon;

class EventReminderResponseData
{
    public function __construct(
        public readonly int $id,
        public readonly string $event_id,
        public readonly string $title,
        public readonly ?string $description,
        public readonly Carbon $date_time,
        public readonly string $status,
        public readonly ?string $reminder_email,
        public readonly Carbon $created_at,
        public readonly Carbon $updated_at
    ) {}

    public static function fromModel($event): self
    {
        return new self(
            id: $event->id,
            event_id: $event->event_id,
            title: $event->title,
            description: $event->description,
            date_time: Carbon::parse($event->date_time),
            status: $event->status,
            reminder_email: $event->reminder_email,
            created_at: Carbon::parse($event->created_at),
            updated_at: Carbon::parse($event->updated_at)
        );
    }
}

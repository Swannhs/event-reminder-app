<?php

namespace App\Data;

use Carbon\Carbon;

class EventReminderData
{
    public function __construct(
        public readonly ?string $event_id,
        public readonly string $title,
        public readonly ?string $description,
        public readonly Carbon $date_time,
        public readonly string $status,
        public readonly ?string $reminder_email
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            event_id: $data['event_id'] ?? null,
            title: $data['title'],
            description: $data['description'] ?? null,
            date_time: Carbon::parse($data['date_time']),
            status: $data['status'] ?? 'upcoming',
            reminder_email: $data['reminder_email'] ?? null
        );
    }

    public function toArray(): array
    {
        return [
            'event_id' => $this->event_id,
            'title' => $this->title,
            'description' => $this->description,
            'date_time' => $this->date_time->toDateTimeString(),
            'status' => $this->status,
            'reminder_email' => $this->reminder_email,
        ];
    }
}

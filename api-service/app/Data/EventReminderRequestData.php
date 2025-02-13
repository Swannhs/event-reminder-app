<?php

namespace App\Data;

use Carbon\Carbon;

class EventReminderRequestData
{
    public function __construct(
        public readonly string $title,
        public readonly ?string $description,
        public readonly Carbon $date_time,
        public readonly string $status,
        public readonly ?string $reminder_email
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            title: $data['title'],
            description: $data['description'] ?? null,
            date_time: Carbon::parse($data['date_time']),
            status: $data['status'] ?? 'upcoming',
            reminder_email: $data['reminder_email'] ?? null
        );
    }
}

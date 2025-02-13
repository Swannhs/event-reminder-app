<?php

namespace App\Http\Resources;

use App\Data\EventReminderResponseData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      schema="EventReminder",
 *      title="Event Reminder Resource",
 *      description="Event Reminder response data",
 *      required={"id", "event_id", "title", "date_time", "status"},
 *      @OA\Property(property="id", type="integer", example=1),
 *      @OA\Property(property="event_id", type="string", example="EVT-12345"),
 *      @OA\Property(property="title", type="string", example="Project Meeting"),
 *      @OA\Property(property="description", type="string", example="Discuss project requirements"),
 *      @OA\Property(property="date_time", type="string", format="date-time", example="2025-02-20T10:00:00Z"),
 *      @OA\Property(property="status", type="string", example="upcoming"),
 *      @OA\Property(property="reminder_email", type="string", example="user@example.com"),
 *      @OA\Property(property="created_at", type="string", format="date-time", example="2025-02-10T12:00:00Z"),
 *      @OA\Property(property="updated_at", type="string", format="date-time", example="2025-02-15T15:00:00Z"),
 * )
 */
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

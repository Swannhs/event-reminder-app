<?php

namespace App\Http\Requests;

use App\Data\EventReminderRequestData;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      schema="EventReminderRequest",
 *      title="Event Reminder Request",
 *      description="Request body for creating an event reminder",
 *      required={"title", "date_time", "status"},
 *      @OA\Property(property="title", type="string", example="Project Meeting"),
 *      @OA\Property(property="description", type="string", nullable=true, example="Discuss project requirements"),
 *      @OA\Property(property="date_time", type="string", format="date-time", example="2025-02-20T10:00:00Z"),
 *      @OA\Property(property="status", type="string", enum={"upcoming", "completed"}, example="upcoming"),
 *      @OA\Property(property="reminder_email", type="string", format="email", nullable=true, example="user@example.com"),
 * )
 */
class StoreEventReminderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date_time' => 'required|date',
            'status' => 'required|string|in:upcoming,completed',
            'reminder_email' => 'nullable|email',
        ];
    }

    public function toDto(): EventReminderRequestData
    {
        return EventReminderRequestData::fromArray($this->validated());
    }
}

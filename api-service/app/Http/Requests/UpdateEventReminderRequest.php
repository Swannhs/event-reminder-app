<?php

namespace App\Http\Requests;

use App\Data\EventReminderRequestData;
use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      schema="EventReminderUpdateRequest",
 *      title="Event Reminder Update Request",
 *      description="Request body for updating an event reminder",
 *      @OA\Property(property="title", type="string", nullable=true, example="Updated Project Meeting"),
 *      @OA\Property(property="description", type="string", nullable=true, example="Updated project discussion"),
 *      @OA\Property(property="date_time", type="string", format="date-time", nullable=true, example="2025-02-21T15:00:00Z"),
 *      @OA\Property(property="status", type="string", enum={"upcoming", "completed"}, nullable=true, example="completed"),
 *      @OA\Property(property="reminder_email", type="string", format="email", nullable=true, example="updated@example.com"),
 * )
 */
class UpdateEventReminderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'date_time' => 'sometimes|date',
            'status' => 'sometimes|string|in:upcoming,completed',
            'reminder_email' => 'nullable|email',
        ];
    }

    public function toDto(): EventReminderRequestData
    {
        return EventReminderRequestData::fromArray($this->validated());
    }
}

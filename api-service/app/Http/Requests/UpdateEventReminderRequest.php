<?php

namespace App\Http\Requests;

use App\Data\EventReminderRequestData;
use Illuminate\Foundation\Http\FormRequest;

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

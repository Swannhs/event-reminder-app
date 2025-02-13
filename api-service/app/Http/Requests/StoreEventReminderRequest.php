<?php

namespace App\Http\Requests;

use App\Data\EventReminderRequestData;
use Illuminate\Foundation\Http\FormRequest;

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

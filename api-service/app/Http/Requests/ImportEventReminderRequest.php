<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *      schema="EventReminderImportRequest",
 *      title="Event Reminder CSV Import Request",
 *      description="Request body for importing event reminders via CSV",
 *      @OA\Property(property="csv_file", type="string", format="binary", description="CSV file to upload"),
 * )
 */
class ImportEventReminderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ];
    }
}

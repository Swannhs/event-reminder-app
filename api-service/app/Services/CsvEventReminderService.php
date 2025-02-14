<?php

namespace App\Services;

use App\Models\EventReminder;
use Illuminate\Support\Facades\Validator;
use League\Csv\Reader;
use League\Csv\Exception;
use Illuminate\Support\Facades\Log;

class CsvEventReminderService
{
    public function importCsv(string $filePath): array
    {
        try {
            $csv = Reader::createFromPath($filePath, 'r');
            $csv->setHeaderOffset(0);
            $records = $csv->getRecords();

            $importedData = [];
            $errors = [];

            foreach ($records as $index => $row) {
                $validator = Validator::make($row, [
                    'title' => 'required|string|max:255',
                    'description' => 'nullable|string',
                    'date_time' => 'required|date',
                    'status' => 'required|string|in:upcoming,completed',
                    'reminder_email' => 'nullable|email',
                ]);

                if ($validator->fails()) {
                    $errors[$index + 1] = $validator->errors()->all();
                    continue;
                }

                $event = EventReminder::create([
                    'title' => $row['title'],
                    'description' => $row['description'] ?? null,
                    'date_time' => $row['date_time'],
                    'status' => $row['status'],
                    'reminder_email' => $row['reminder_email'] ?? null,
                ]);

                $importedData[] = $event;
            }

            return [
                'imported' => $importedData,
                'errors' => $errors
            ];
        } catch (Exception $e) {
            Log::error('CSV Import Error: ' . $e->getMessage());
            return ['error' => 'Invalid CSV format'];
        }
    }
}

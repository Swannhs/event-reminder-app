<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportEventReminderRequest;
use App\Services\CsvEventReminderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;

/**
 * @OA\Tag(name="Event Reminders", description="API Endpoints for managing event reminders")
 */
class CsvEventReminderController extends Controller
{
    protected CsvEventReminderService $csvService;

    public function __construct(CsvEventReminderService $csvService)
    {
        $this->csvService = $csvService;
    }

    /**
     * @OA\Post(
     *      path="/api/event-reminders/import",
     *      operationId="importEventReminders",
     *      tags={"Event Reminders"},
     *      summary="Import event reminders from a CSV file",
     *      description="Uploads a CSV file and processes event reminders in bulk",
     *      @OA\RequestBody(
     *          required=true,
     *          description="CSV file upload",
     *          @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  @OA\Property(property="csv_file", type="string", format="binary", description="The CSV file to upload")
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="CSV imported successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="CSV imported successfully"),
     *              @OA\Property(property="imported_count", type="integer", example=3),
     *              @OA\Property(property="errors", type="object", example={})
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Invalid CSV format",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=false),
     *              @OA\Property(property="message", type="string", example="Invalid CSV format")
     *          )
     *      )
     * )
     */
    public function importCsv(ImportEventReminderRequest $request): JsonResponse
    {
        $file = $request->file('csv_file');
        $filePath = $file->storeAs('uploads', 'event_reminders.csv');

        $result = $this->csvService->importCsv(storage_path("app/{$filePath}"));

        if (isset($result['error'])) {
            return response()->json([
                'success' => false,
                'message' => $result['error'],
            ], Response::HTTP_BAD_REQUEST);
        }

        return response()->json([
            'success' => true,
            'message' => 'CSV imported successfully',
            'imported_count' => count($result['imported']),
            'errors' => $result['errors']
        ], Response::HTTP_OK);
    }
}

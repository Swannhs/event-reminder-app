<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventReminderRequest;
use App\Http\Requests\UpdateEventReminderRequest;
use App\Http\Resources\EventReminderResource;
use App\Services\EventReminderService;
use Illuminate\Http\JsonResponse;
use OpenApi\Annotations as OA;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Event Reminder API",
 *      description="API documentation for managing event reminders",
 *      @OA\Contact(email="support@example.com"),
 * )
 *
 * @OA\Tag(name="Event Reminders", description="API Endpoints for managing event reminders")
 */
class EventReminderController extends Controller
{
    protected EventReminderService $eventReminderService;

    public function __construct(EventReminderService $eventReminderService)
    {
        $this->eventReminderService = $eventReminderService;
    }

    /**
     * @OA\Get(
     *      path="/api/event-reminders",
     *      operationId="getEventReminders",
     *      tags={"Event Reminders"},
     *      summary="Get all event reminders",
     *      @OA\Response(response=200, description="Successful retrieval of event reminders")
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json(EventReminderResource::collection($this->eventReminderService->getAllEvents()), ResponseAlias::HTTP_OK);
    }

    /**
     * @OA\Post(
     *      path="/api/event-reminders",
     *      operationId="createEventReminder",
     *      tags={"Event Reminders"},
     *      summary="Create a new event reminder",
     *      @OA\Response(response=201, description="Event created successfully")
     * )
     */
    public function store(StoreEventReminderRequest $request): JsonResponse
    {
        $event = $this->eventReminderService->createEvent($request->toDto());
        return response()->json(new EventReminderResource($event), ResponseAlias::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *      path="/api/event-reminders/{id}",
     *      operationId="getEventReminderById",
     *      tags={"Event Reminders"},
     *      summary="Get an event reminder by ID",
     *      @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *      @OA\Response(response=200, description="Successful retrieval of event reminder")
     * )
     */
    public function show(int $id): JsonResponse
    {
        return response()->json(new EventReminderResource($this->eventReminderService->getEventById($id)), ResponseAlias::HTTP_OK);
    }

    /**
     * @OA\Put(
     *      path="/api/event-reminders/{id}",
     *      operationId="updateEventReminder",
     *      tags={"Event Reminders"},
     *      summary="Update an existing event reminder",
     *      @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *      @OA\Response(response=200, description="Event updated successfully")
     * )
     */
    public function update(UpdateEventReminderRequest $request, int $id): JsonResponse
    {
        $event = $this->eventReminderService->updateEvent($id, $request->toDto());
        return response()->json(new EventReminderResource($event), ResponseAlias::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *      path="/api/event-reminders/{id}",
     *      operationId="deleteEventReminder",
     *      tags={"Event Reminders"},
     *      summary="Delete an event reminder",
     *      @OA\Response(response=200, description="Event deleted successfully")
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        return response()->json(['message' => $this->eventReminderService->deleteEvent($id) ? 'Deleted' : 'Not Found'], ResponseAlias::HTTP_OK);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEventReminderRequest;
use App\Http\Requests\UpdateEventReminderRequest;
use App\Http\Resources\EventReminderResource;
use App\Services\EventReminderService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
     *      summary="Get all event reminders with pagination",
     *      @OA\Parameter(
     *          name="page",
     *          in="query",
     *          required=false,
     *          description="Page number for pagination",
     *          @OA\Schema(type="integer", example=1)
     *      ),
     *      @OA\Parameter(
     *          name="per_page",
     *          in="query",
     *          required=false,
     *          description="Number of items per page (default: 10)",
     *          @OA\Schema(type="integer", example=10)
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful retrieval of paginated event reminders",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="data", type="array", @OA\Items(ref="#/components/schemas/EventReminder")),
     *              @OA\Property(property="links", type="object",
     *                  @OA\Property(property="first", type="string", example="http://localhost/api/event-reminders?page=1"),
     *                  @OA\Property(property="last", type="string", example="http://localhost/api/event-reminders?page=5"),
     *                  @OA\Property(property="prev", type="string", nullable=true, example="http://localhost/api/event-reminders?page=1"),
     *                  @OA\Property(property="next", type="string", nullable=true, example="http://localhost/api/event-reminders?page=3")
     *              ),
     *              @OA\Property(property="meta", type="object",
     *                  @OA\Property(property="current_page", type="integer", example=2),
     *                  @OA\Property(property="from", type="integer", example=11),
     *                  @OA\Property(property="last_page", type="integer", example=5),
     *                  @OA\Property(property="per_page", type="integer", example=10),
     *                  @OA\Property(property="to", type="integer", example=20),
     *                  @OA\Property(property="total", type="integer", example=50)
     *              )
     *          )
     *      )
     * )
     */
    public function index(): JsonResponse
    {
        return EventReminderResource::collection($this->eventReminderService->getAllEvents())->response();
    }

    /**
     * @OA\Post(
     *      path="/api/event-reminders",
     *      operationId="createEventReminder",
     *      tags={"Event Reminders"},
     *      summary="Create a new event reminder",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/EventReminderRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Event created successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Event reminder created successfully"),
     *              @OA\Property(property="data", ref="#/components/schemas/EventReminder")
     *          )
     *      )
     * )
     */
    public function store(StoreEventReminderRequest $request): JsonResponse
    {
        $event = $this->eventReminderService->createEvent($request->toDto());
        return response()->json([
            'success' => true,
            'message' => 'Event reminder created successfully',
            'data' => new EventReminderResource($event),
        ], ResponseAlias::HTTP_CREATED);
    }

    /**
     * @OA\Get(
     *      path="/api/event-reminders/{id}",
     *      operationId="getEventReminderById",
     *      tags={"Event Reminders"},
     *      summary="Get an event reminder by ID",
     *      @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *      @OA\Response(
     *          response=200,
     *          description="Successful retrieval of event reminder",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Event reminder retrieved successfully"),
     *              @OA\Property(property="data", ref="#/components/schemas/EventReminder")
     *          )
     *      ),
     *      @OA\Response(response=404, description="Event not found")
     * )
     */
    public function show(int $id): JsonResponse
    {
        $event = $this->eventReminderService->getEventById($id);

        if (!$event) {
            return response()->json([
                'success' => false,
                'message' => 'Event reminder not found'
            ], ResponseAlias::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'message' => 'Event reminder retrieved successfully',
            'data' => new EventReminderResource($event),
        ], ResponseAlias::HTTP_OK);
    }

    /**
     * @OA\Put(
     *      path="/api/event-reminders/{id}",
     *      operationId="updateEventReminder",
     *      tags={"Event Reminders"},
     *      summary="Update an existing event reminder",
     *      @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/EventReminderUpdateRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Event updated successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Event reminder updated successfully"),
     *              @OA\Property(property="data", ref="#/components/schemas/EventReminder")
     *          )
     *      ),
     *      @OA\Response(response=404, description="Event not found")
     * )
     */
    public function update(UpdateEventReminderRequest $request, int $id): JsonResponse
    {
        try {
            $event = $this->eventReminderService->updateEvent($id, $request->toDto());

            return response()->json([
                'success' => true,
                'message' => 'Event reminder updated successfully',
                'data' => new EventReminderResource($event),
            ], ResponseAlias::HTTP_OK);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Event reminder not found'
            ], ResponseAlias::HTTP_NOT_FOUND);
        }
    }

    /**
     * @OA\Delete(
     *      path="/api/event-reminders/{id}",
     *      operationId="deleteEventReminder",
     *      tags={"Event Reminders"},
     *      summary="Delete an event reminder",
     *      @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *      @OA\Response(
     *          response=200,
     *          description="Event deleted successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="success", type="boolean", example=true),
     *              @OA\Property(property="message", type="string", example="Event reminder deleted successfully")
     *          )
     *      ),
     *      @OA\Response(response=404, description="Event not found")
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->eventReminderService->deleteEvent($id);

        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Event reminder not found'
            ], ResponseAlias::HTTP_NOT_FOUND);
        }

        return response()->json([
            'success' => true,
            'message' => 'Event reminder deleted successfully',
        ], ResponseAlias::HTTP_OK);
    }
}

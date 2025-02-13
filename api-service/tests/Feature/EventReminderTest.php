<?php

namespace Tests\Feature;

use App\Models\EventReminder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventReminderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_fetch_paginated_event_reminders()
    {
        EventReminder::factory()->count(15)->create();

        $response = $this->getJson('/api/event-reminders');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => [
                        'id', 'event_id', 'title', 'description', 'date_time', 'status', 'reminder_email', 'created_at', 'updated_at'
                    ]
                ],
                'links',
                'meta'
            ]);
    }

    /** @test */
    public function it_can_create_an_event_reminder()
    {
        $eventData = [
            'title' => 'Test Event',
            'description' => 'This is a test event',
            'date_time' => now()->addDays(3)->toDateTimeString(),
            'status' => 'upcoming',
            'reminder_email' => 'test@example.com'
        ];

        $response = $this->postJson('/api/event-reminders', $eventData);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'id', 'event_id', 'title', 'description', 'date_time', 'status', 'reminder_email', 'created_at', 'updated_at'
            ]);
    }

    /** @test */
    public function it_can_fetch_a_single_event_reminder()
    {
        $event = EventReminder::factory()->create();

        $response = $this->getJson("/api/event-reminders/{$event->id}");

        $response->assertStatus(200)
            ->assertJson([
                'id' => $event->id,
                'event_id' => $event->event_id,
                'title' => $event->title,
                'description' => $event->description,
                'date_time' => $event->date_time->format('Y-m-d H:i:s'),
                'status' => $event->status,
                'reminder_email' => $event->reminder_email,
            ]);
    }

    /** @test */
    public function it_can_update_an_event_reminder()
    {
        $event = EventReminder::factory()->create();

        $updatedData = [
            'title' => 'Updated Event Title',
            'status' => 'completed'
        ];

        $response = $this->putJson("/api/event-reminders/{$event->id}", $updatedData);

        $event->refresh();

        $response->assertStatus(200)
            ->assertJson([
                'id' => $event->id,
                'title' => 'Updated Event Title',
                'status' => 'completed',
                'updated_at' => $event->updated_at->format('Y-m-d H:i:s')
            ]);
    }

    /** @test */
    public function it_can_delete_an_event_reminder()
    {
        $event = EventReminder::factory()->create();

        $response = $this->deleteJson("/api/event-reminders/{$event->id}");

        $response->assertStatus(200)
            ->assertJson(['message' => 'Deleted']);

        $this->assertDatabaseMissing('event_reminders', ['id' => $event->id]);
    }
}

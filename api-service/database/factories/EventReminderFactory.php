<?php

namespace Database\Factories;

use App\Models\EventReminder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EventReminder>
 */
class EventReminderFactory extends Factory
{
    protected $model = EventReminder::class;

    public function definition(): array
    {
        return [
            'event_id' => 'EVT-' . strtoupper(Str::random(6)),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'date_time' => $this->faker->dateTimeBetween('now', '+1 year'),
            'status' => $this->faker->randomElement(['upcoming', 'completed']),
            'reminder_email' => $this->faker->optional()->safeEmail(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}

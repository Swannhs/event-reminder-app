<?php

namespace Database\Seeders;

use App\Models\EventReminder;
use Illuminate\Database\Seeder;

class EventReminderSeeder extends Seeder
{
    public function run(): void
    {
        EventReminder::factory()->count(20)->create();
    }
}

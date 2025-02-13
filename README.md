project_root/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Api/
│   │   │   │   ├── EventReminderController.php
│   ├── Models/
│   │   ├── EventReminder.php
│   ├── Services/
│   │   ├── EventReminderService.php
│   ├── Repositories/
│   │   ├── EventReminderRepository.php
│   ├── Jobs/
│   │   ├── SendEventReminderJob.php
│   ├── Mail/
│   │   ├── EventReminderMail.php
│   ├── Events/
│   │   ├── EventReminderCreated.php
│   ├── Listeners/
│   │   ├── SendEventReminderNotification.php
│
├── bootstrap/
│   ├── app.php
│
├── config/
│   ├── app.php
│   ├── database.php
│   ├── mail.php
│
├── database/
│   ├── migrations/
│   │   ├── 2025_02_13_000000_create_event_reminders_table.php
│   ├── seeders/
│   │   ├── DatabaseSeeder.php
│
├── routes/
│   ├── api.php
│
├── storage/
│
├── tests/
│   ├── Feature/
│   │   ├── EventReminderTest.php
│   ├── Unit/
│   │   ├── EventReminderServiceTest.php
│
├── .env
├── .gitignore
├── artisan
├── composer.json
├── Dockerfile
├── docker-compose.yml
└── README.md

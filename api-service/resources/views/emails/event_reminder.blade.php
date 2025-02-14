<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Reminder</title>
</head>
<body>
    <h2>Reminder: {{ $event->title }}</h2>
    <p><strong>Description:</strong> {{ $event->description }}</p>
    <p><strong>Date & Time:</strong> {{ \Carbon\Carbon::parse($event->date_time)->format('l, F j, Y \a\t h:i A') }}</p>
    <p><strong>Status:</strong> {{ ucfirst($event->status) }}</p>

    <p>Thank you,<br>Event Reminder System</p>
</body>
</html>

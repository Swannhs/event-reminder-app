<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Reminder</title>
</head>
<body>
    <h2>Reminder: {{ $event->title }}</h2>
    <p>{{ $event->description }}</p>
    <p><strong>Date & Time:</strong> {{ $event->date_time }}</p>
    <p>Best regards, <br> Event Reminder App</p>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Appointment Request</title>
</head>
<body style="font-family: Arial, sans-serif;">
    <h2>🐾 New Appointment Request</h2>
    <p>Dear Dr. {{ ucfirst($appointment->vet->name) }},</p>
    <p>You have received a new appointment request from <strong>{{ ucfirst($appointment->owner->name) }}</strong>.</p>
   <p><strong>Pet Health Condition:</strong> {{ $health_condition }}</p>

    <ul>
        <li><strong>Date:</strong> {{ $appointment->date }}</li>
        <li><strong>Time:</strong> {{ $appointment->time }}</li>
        <li><strong>Message:</strong> {{ $appointment->message ?? 'No message provided' }}</li>
    </ul>

    <p>Please check your Vet Dashboard to respond.</p>
</body>
</html>

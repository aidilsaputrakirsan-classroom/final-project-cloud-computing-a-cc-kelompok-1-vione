<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Appointment Status Updated</title>
</head>
<body style="font-family: Arial, sans-serif;">
    <h2>🐾 Appointment Update</h2>
    <p>Dear {{ ucfirst($appointment->owner->name) }},</p>
    <p>Your appointment with Dr. {{ ucfirst($appointment->vet->name) }} has been updated.</p>

    <ul>
        <li><strong>Date:</strong> {{ $appointment->date }}</li>
        <li><strong>Time:</strong> {{ $appointment->time }}</li>
        <li><strong>Status:</strong> {{ $appointment->status }}</li>
        
    </ul>
  @if($appointment->status == 'Cancelled')
    <p>The owner has cancelled this appointment.</p>
@endif

    <p>Thank you for using PetCare 🐶</p>
</body>
</html>

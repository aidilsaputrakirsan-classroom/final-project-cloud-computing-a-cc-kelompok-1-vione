<!DOCTYPE html>
<html>
<head>
    <title>New Appointment Request</title>
</head>
<body style="font-family: Arial, sans-serif;">

    <h2>Hello Dr. {{ $appointment->vet->name ?? 'Vet' }},</h2>

    <p>You have received a new appointment request.</p>

    <h3>Appointment Details:</h3>
    <ul>
        <li><strong>Owner:</strong> {{ $appointment->owner->name ?? 'Unknown' }}</li>
        <li><strong>Pet Name:</strong> 
            @if($appointment->pet)
                {{ $appointment->pet->name }} (Owner Pet)
            @elseif($appointment->shelterPet)
                {{ $appointment->shelterPet->name }} (Shelter Pet)
            @else
                Unknown Pet
            @endif
        </li>
        <li><strong>Date:</strong> {{ $appointment->date }}</li>
        <li><strong>Time:</strong> {{ $appointment->time }}</li>
        <li><strong>Message:</strong> {{ $appointment->message ?? 'No message provided' }}</li>
        <li><strong>Current Status:</strong> {{ $appointment->status }}</li>
    </ul>

    <p>Please login to your dashboard to Approve or Reject this appointment.</p>

    <p>Thank you,<br>
    Vione App Team</p>

</body>
</html>
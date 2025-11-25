<!DOCTYPE html>
<html>
<head>
    <title>Appointment Status Update</title>
</head>
<body style="font-family: Arial, sans-serif;">

    <h2>Hello,</h2>

    <p>The status of your appointment has been updated.</p>

    <h3>Appointment Details:</h3>
    <ul>
        <li><strong>Vet:</strong> Dr. {{ $appointment->vet->name ?? 'Unknown' }}</li>
        <li><strong>Pet Name:</strong> 
            @if($appointment->pet)
                {{ $appointment->pet->name }}
            @elseif($appointment->shelterPet)
                {{ $appointment->shelterPet->name }}
            @else
                Unknown Pet
            @endif
        </li>
        <li><strong>Date:</strong> {{ $appointment->date }}</li>
        <li><strong>Time:</strong> {{ $appointment->time }}</li>
        <li><strong>New Status:</strong> <span style="font-weight:bold; color: {{ $appointment->status == 'Approved' ? 'green' : ($appointment->status == 'Rejected' ? 'red' : 'orange') }}">{{ $appointment->status }}</span></li>
    </ul>

    @if($appointment->status == 'Approved')
        <p>Please make sure to arrive on time.</p>
    @elseif($appointment->status == 'Rejected')
        <p>Sorry, the vet cannot accept this appointment. Please try booking another time.</p>
    @endif

    <p>Thank you,<br>
    Vione App Team</p>

</body>
</html>
@extends('layouts.ownerpanel')

@section('content')
<div class="container mt-5">
    <h2 class="fw-bold text-primary mb-4">My Appointments</h2>

    @if($appointments->isEmpty())
        <div class="alert alert-info">You have not booked any appointments yet.</div>
    @else
        <div class="row">
            @foreach($appointments as $appointment)
                <div class="col-md-4 mb-4">
                    <div class="card shadow border-0 rounded-4 h-100">
                        <div class="card-body">
                            <h5 class="fw-bold text-dark mb-2">
                                Vet: {{ ucfirst($appointment->vet->name) }}
                            </h5>
                            <p><strong>Date:</strong> {{ $appointment->date }}</p>
                            <p><strong>Time:</strong> {{ $appointment->time }}</p>
                            <p><strong>Status:</strong>
                                <span class="badge 
                                    @if($appointment->status == 'Approved') bg-success
                                    @elseif($appointment->status == 'Rejected') bg-danger
                                    @else bg-warning text-dark @endif">
                                    {{ $appointment->status }}
                                </span>
                            </p>
                            @if($appointment->status == 'Pending' || $appointment->status == 'Approved')
    <form action="{{ route('owner.appointment.cancel', $appointment->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
        @csrf
        @method('PUT')
        <button type="submit" class="btn btn-danger btn-sm mt-2">
            <i class="fa-solid fa-xmark"></i> Cancel
        </button>
    </form>
@endif

                            <p><strong>Message:</strong> {{ $appointment->message ?? 'No message' }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

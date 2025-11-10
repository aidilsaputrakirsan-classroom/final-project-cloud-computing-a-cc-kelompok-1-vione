@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h2 class="text-center fw-bold text-primary mb-4">
        <i class="fa-solid fa-calendar-check me-2"></i> My Pet Appointments
    </h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    @if($appointments->isEmpty())
        <p class="text-center text-muted fs-5">No appointments yet.</p>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Pet</th>
                        <th>Vet</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th>Feedback</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $index => $appointment)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $appointment->pet->pet_name ?? 'Unknown' }}</td>
                        <td>{{ $appointment->vet->name ?? 'N/A' }}</td>
                        <td>{{ $appointment->date }}</td>
                        <td>{{ $appointment->time }}</td>
                        <td>
                            <span class="badge
                                @if($appointment->status == 'Pending') bg-warning text-dark
                                @elseif($appointment->status == 'Approved') bg-success
                                @elseif($appointment->status == 'Cancelled') bg-secondary
                                @else bg-danger @endif">
                                {{ $appointment->status }}
                            </span>
                        </td>
                        <td>
                            @if($appointment->status === 'Pending' || $appointment->status === 'Approved')
                               <form action="{{ route('shelter.appointment.cancel', $appointment->id) }}" method="POST">
    @csrf
    @method('PUT')
    <button type="submit" class="btn btn-danger btn-sm"
        onclick="return confirm('Cancel this appointment?')">
        Cancel
    </button>
</form>

                            @else
                                <small class="text-muted">No action</small>
                            @endif
                        </td>
                   <td>
    @if($appointment->vet_feedback)
        <span class="text-success">
            {{ $appointment->vet_feedback }}
        </span>
    @elseif($appointment->medicalHistory && $appointment->medicalHistory->last())
        <span class="text-success">
            {{ $appointment->medicalHistory->last()->notes }}
        </span>
    @else
        <span class="text-muted">No feedback yet</span>
    @endif
</td>



                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

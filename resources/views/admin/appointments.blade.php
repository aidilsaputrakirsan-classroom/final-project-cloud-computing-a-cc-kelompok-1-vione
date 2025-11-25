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
        <div class="text-center py-5">
            <i class="fa-regular fa-folder-open fa-3x text-muted mb-3"></i>
            <p class="text-muted fs-5">No appointments scheduled yet.</p>
        </div>
    @else
        <div class="table-responsive shadow-sm rounded">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-primary text-center">
                    <tr>
                        <th>#</th>
                        <th>Pet Name</th>
                        <th>Vet</th>
                        <th>Date & Time</th>
                        <th>Status</th>
                        <th>Feedback</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $index => $appointment)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        
                        <!-- ✅ PERBAIKAN UTAMA: Cek Pet Owner ATAU Pet Shelter -->
                        <td class="fw-bold text-primary">
                            @if($appointment->pet)
                                {{ $appointment->pet->name }} <span class="badge bg-info text-dark" style="font-size: 0.6rem;">Owner</span>
                            @elseif($appointment->shelterPet)
                                {{ $appointment->shelterPet->name }} <span class="badge bg-warning text-dark" style="font-size: 0.6rem;">Shelter</span>
                            @else
                                <span class="text-muted fst-italic">Unknown Pet</span>
                            @endif
                        </td>

                        <td>Dr. {{ $appointment->vet->name ?? 'N/A' }}</td>
                        
                        <td>
                            <div><i class="fa-regular fa-calendar me-1"></i> {{ date('d M Y', strtotime($appointment->date)) }}</div>
                            <div class="small text-muted"><i class="fa-regular fa-clock me-1"></i> {{ date('H:i', strtotime($appointment->time)) }}</div>
                        </td>

                        <td class="text-center">
                            @if($appointment->status == 'Pending')
                                <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Pending</span>
                            @elseif($appointment->status == 'Approved')
                                <span class="badge bg-success px-3 py-2 rounded-pill">Approved</span>
                            @elseif($appointment->status == 'Completed')
                                <span class="badge bg-primary px-3 py-2 rounded-pill">Completed</span>
                            @elseif($appointment->status == 'Cancelled')
                                <span class="badge bg-secondary px-3 py-2 rounded-pill">Cancelled</span>
                            @else
                                <span class="badge bg-danger px-3 py-2 rounded-pill">{{ $appointment->status }}</span>
                            @endif
                        </td>

                        <td>
                            @if($appointment->vet_feedback)
                                <div class="p-2 bg-light border rounded small text-start">
                                    <i class="fa-solid fa-notes-medical text-success me-1"></i> 
                                    {{ Str::limit($appointment->vet_feedback, 50) }}
                                </div>
                            @elseif($appointment->medicalHistory && $appointment->medicalHistory->last())
                                <div class="p-2 bg-light border rounded small text-start">
                                    <i class="fa-solid fa-notes-medical text-success me-1"></i> 
                                    {{ Str::limit($appointment->medicalHistory->last()->notes, 50) }}
                                </div>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>

                        <td class="text-center">
                            @if($appointment->status === 'Pending' || $appointment->status === 'Approved')
                                <form action="{{ route('shelter.appointment.cancel', $appointment->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-outline-danger btn-sm" 
                                            onclick="return confirm('Are you sure you want to cancel this appointment?')">
                                        <i class="fa-solid fa-ban"></i> Cancel
                                    </button>
                                </form>
                            @else
                                <button class="btn btn-secondary btn-sm" disabled>
                                    <i class="fa-solid fa-lock"></i> Closed
                                </button>
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
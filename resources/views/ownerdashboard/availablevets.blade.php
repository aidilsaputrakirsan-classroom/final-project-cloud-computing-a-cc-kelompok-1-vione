@extends('layouts.ownerpanel')

@section('content')

@if(session('error'))
    <div class="alert alert-danger text-center mt-3">
        {{ session('error') }}
    </div>
@endif
@if(session('success'))
    <div class="alert alert-success text-center mt-3">
        {{ session('success') }}
    </div>
@endif

<div class="container mt-5">
    <h2 class="text-center fw-bold text-primary mb-4">
        <i class="fa-solid fa-user-doctor me-2"></i> Available Vets
    </h2>

    <div class="row">
        @forelse($vets as $vet)
            <div class="col-md-4 mb-4">
                <div class="card shadow border-0 rounded-4 h-100">
                    <div class="position-relative">
                        <!-- Optional Profile Image -->
                       @if(!empty($vet->vetProfile) && !empty($vet->vetProfile->photo))
    <img src="{{ asset('storage/' . $vet->vetProfile->photo) }}" 
         class="card-img-top rounded-top-4" 
         alt="{{ $vet->name }}" 
         style="height:230px; object-fit:cover;">
@else
    <img src="{{ asset('images/vet-placeholder.jpg') }}" 
         class="card-img-top rounded-top-4" 
         alt="No Photo" 
         style="height:230px; object-fit:cover;">
@endif

                    </div>

                    <div class="card-body bg-light text-center">
                        <h5 class="fw-bold text-dark">{{ ucfirst($vet->name) }}</h5>
                        <p class="text-muted mb-1">{{ $vet->email }}</p>

                        @if(isset($vet->vetProfile))
                            <p><b>Specialization:</b> {{ $vet->vetProfile->specialization ?? 'N/A' }}</p>
                            <p><b>Experience:</b> {{ $vet->vetProfile->experience ?? 'N/A' }} years</p>
                            <p><b>Clinic:</b> {{ $vet->vetProfile->clinic_name ?? 'N/A' }}</p>
                            <p><strong>Available Days:</strong> {{ $vet->vetProfile->available_days ?? 'Not set' }}</p>
                     <p><strong>Available Time:</strong> {{ $vet->vetProfile->available_time ?? 'Not set' }}</p>

                        @else
                            <p><b>Specialization:</b> General Vet</p>
                            <p><b>Experience:</b> N/A</p>
                        @endif

                         <!-- Button trigger modal -->
                        <button type="button" class="btn btn-outline-primary mt-2 px-4" 
                                data-bs-toggle="modal" data-bs-target="#bookModal{{ $vet->id }}">
                            <i class="fa-solid fa-calendar-check me-2"></i> Book Appointment
                        </button>
                        
                    </div>
                </div>
            </div>

        <!-- Appointment Modal -->
            <div class="modal fade" id="bookModal{{ $vet->id }}" tabindex="-1" aria-labelledby="bookModalLabel{{ $vet->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-4 border-0 shadow">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title fw-bold" id="bookModalLabel{{ $vet->id }}">
                                <i class="fa-solid fa-calendar-check me-2"></i> Book Appointment with {{ ucfirst($vet->name) }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                       <form action="{{ route('appointments.store') }}" method="POST">
        @csrf
        <input type="hidden" name="vet_id" value="{{ $vet->id }}">

        <div class="mb-3">
            <label for="date" class="form-label">Choose Date</label>
            <input type="date" name="date" class="form-control" required
                   min="{{ now()->toDateString() }}">
            <small class="text-muted">Available: {{ $vet->vetProfile->available_days ?? 'Not set' }}</small>
        </div>

        <div class="mb-3">
            <label for="time" class="form-label">Choose Time</label>
            <input type="time" name="time" class="form-control" required>
            <small class="text-muted">Available: {{ $vet->vetProfile->available_time ?? 'Not set' }}</small>
        </div>
        <div class="mb-3">
    <label for="pet_id" class="form-label">Select Pet</label>
    <select name="pet_id" class="form-select" required>
        <option value="">-- Choose Your Pet --</option>
        @foreach($pets as $pet)
            <option value="{{ $pet->id }}">{{ $pet->pet_name }}</option>
        @endforeach
    </select>
</div>


        <div class="mb-3">
            <label for="message" class="form-label">Message (optional)</label>
            <textarea name="message" class="form-control"></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100">Book Appointment</button>
    </form>                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <p class="text-muted fs-5">No vets registered yet.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection

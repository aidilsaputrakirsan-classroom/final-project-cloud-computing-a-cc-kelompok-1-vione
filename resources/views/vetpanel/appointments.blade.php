@extends('layouts.vetpanel')

@section('content')
<div class="container mt-5">
    <h2 class="fw-bold text-primary mb-4 text-center">
        <i class="fa-solid fa-calendar-day me-2"></i> Appointment Requests
    </h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    @if($appointments->isEmpty())
        <p class="text-center text-muted fs-5">No appointments yet.</p>
    @else
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-primary">
                    <tr>
                        <th>#</th>
                        <th>Owner Name</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Message</th>
                        <th>Status</th>
                        <th>Pet Info</th>
                        <th>Vet Feedback</th>
                        <th>Update Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($appointments as $index => $appointment)
                        @php
                            $petName = $appointment->pet->name ?? $appointment->shelterPet->name ?? 'N/A';
                            $healthInfo = $appointment->pet->medical_info ?? $appointment->shelterPet->medical_info ?? 'Not specified';
                        @endphp

                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ ucfirst($appointment->owner->name ?? 'N/A') }}</td>
                            <td>{{ $appointment->date }}</td>
                            <td>{{ $appointment->time }}</td>
                            <td>{{ $appointment->message ?? '—' }}</td>
                            <td>
                                @if($appointment->status == 'Pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($appointment->status == 'Approved')
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>

                           <td>
  <strong>{{ $petName }}</strong><br>
  <small class="text-muted">Health: {{ $healthInfo }}</small>
  <br>
  <button class="btn btn-sm btn-link text-primary p-0" 
          data-bs-toggle="modal" 
          data-bs-target="#historyModal{{ $appointment->id }}">
      View History
  </button>
</td>

                            <td>
                                @if($appointment->status == 'Approved')
                                    <button class="btn btn-sm btn-outline-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#feedbackModal{{ $appointment->id }}">
                                        Add / Edit Feedback
                                    </button>
                                @else
                                    <small class="text-muted">Feedback unavailable</small>
                                @endif
                            </td>

                            <td>
                                <form action="{{ route('vet.appointment.status', $appointment->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <select name="status"
                                            class="form-select form-select-sm w-auto d-inline"
                                            onchange="this.form.submit()"
                                            style="min-width:120px;">
                                        <option value="Pending" {{ $appointment->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Approved" {{ $appointment->status == 'Approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="Rejected" {{ $appointment->status == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                </form>
                            </td>
                        </tr>

                        <!-- Feedback Modal -->
                        <div class="modal fade" id="feedbackModal{{ $appointment->id }}" tabindex="-1" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered">
                            <form method="POST" action="{{ route('vet.feedback', $appointment->id) }}">
                              @csrf
                              @method('PUT')
                              <div class="modal-content">
                                <div class="modal-header bg-success text-white">
                                  <h5 class="modal-title">Feedback for {{ $petName }}</h5>
                                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                  <div class="mb-3">
                                    <label class="form-label">Previous Health Info:</label>
                                    <p class="form-control-plaintext text-muted">
                                      {{ $healthInfo }}
                                    </p>
                                  </div>

                                  <div class="mb-3">
                                    <label class="form-label">Vet Feedback / Updated Condition</label>
                                    <textarea name="vet_feedback" class="form-control" rows="3"
                                              placeholder="Enter updated diagnosis or treatment notes">{{ $appointment->vet_feedback }}</textarea>
                                  </div>
                                </div>

                                <div class="modal-footer">
                                  <button type="submit" class="btn btn-success w-100">Save Feedback</button>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>

                        <!-- Medical History Modal -->
<div class="modal fade" id="historyModal{{ $appointment->id }}" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content rounded-4 border-0 shadow">
      <div class="modal-header bg-info text-white">
        <h5 class="modal-title">Medical History — {{ $petName }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        @php
          $histories = \App\Models\PetMedicalHistory::where('pet_id', $appointment->pet?->id)
                      ->orWhere('shelter_pet_id', $appointment->shelterPet?->id)
                      ->orderBy('created_at', 'desc')
                      ->get();
        @endphp

        @if($histories->isEmpty())
          <p class="text-muted text-center">No medical history available yet.</p>
        @else
          <ul class="list-group">
            @foreach($histories as $record)
              <li class="list-group-item">
                <strong>{{ $record->vet->name ?? 'Unknown Vet' }}</strong>
                <span class="text-muted float-end">{{ $record->created_at->format('d M Y, h:i A') }}</span>
                <p class="mt-2 mb-0">{{ $record->notes }}</p>
              </li>
            @endforeach
          </ul>
        @endif
      </div>
    </div>
  </div>
</div>

                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection

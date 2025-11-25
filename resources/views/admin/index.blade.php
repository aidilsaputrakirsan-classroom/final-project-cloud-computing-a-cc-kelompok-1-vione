@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h2 class="fw-bold text-primary text-center mb-4">
        🏠 Shelter Dashboard — Manage Your Pets
    </h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger text-center">{{ session('error') }}</div>
    @endif

    <!-- 🔹 Add Pet Button -->
    <div class="text-center mb-4">
        <button type="button" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#addPetModal">
            <i class="fa-solid fa-plus-circle me-2"></i> Add New Pet
        </button>
    </div>

    <!-- 🔹 Add Pet Modal -->
    <div class="modal fade" id="addPetModal" tabindex="-1" aria-labelledby="addPetModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="POST" action="{{ route('shelter.storepet') }}" enctype="multipart/form-data" class="modal-content">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title fw-bold" id="addPetModalLabel">
                        <i class="fa-solid fa-paw me-2"></i> Add a Pet for Adoption
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pet Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Species</label>
                        <input type="text" name="species" class="form-control" placeholder="e.g., Dog, Cat">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Breed</label>
                        <input type="text" name="breed" class="form-control" placeholder="e.g., Labrador, Persian">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Age</label>
                        <input type="number" name="age" class="form-control" min="0" placeholder="Age in years">
                    </div>
                    
                    <!-- 🟢 PERBAIKAN: Mengubah input teks 'gender' menjadi dropdown -->
                    <div class="mb-3">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-select">
                            <option value="">Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="perempuan">Perempuan</option>
                            <option value="laki-laki">Laki-Laki</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Health Status</label>
                        <input type="text" name="medical_info" class="form-control" placeholder="Healthy, Vaccinated, etc.">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Pet Image</label>
                        <!-- Input 'name="photo"' ini SUDAH BENAR untuk ShelterController -->
                        <input type="file" name="photo" class="form-control" accept="image/*">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Pet</button>
                </div>
            </form>
        </div>
    </div>

    <!-- 🔹 Pet Cards -->
    @if($pets->isEmpty())
        <p class="text-center text-muted fs-5">No pets available yet.</p>
    @else
        <div class="row">
            @foreach($pets as $pet)
                <div class="col-md-4 mb-4">
                    <div class="card shadow border-0 rounded-4 h-100">
                        
                        <!-- Path 'storage/' ini SUDAH BENAR -->
                        @if($pet->photo)
                            <img src="{{ asset('storage/' . $pet->photo) }}" class="card-img-top rounded-top-4" style="height:230px; object-fit:cover;">
                        @else
                            <img src="https://placehold.co/600x400/eeeeee/aaaaaa?text=No+Photo" class="card-img-top rounded-top-4" style="height:230px; object-fit:cover;">
                        @endif
                        
                        <div class="card-body text-center">
                            <h5 class="fw-bold">{{ ucfirst($pet->name) }}</h5>
                            <p class="text-muted mb-1">{{ $pet->species }} | {{ $pet->breed }}</p>
                            <p><strong>Age:</strong> {{ $pet->age ?? 'N/A' }} years</p>
                            <p><strong>Gender:</strong> {{ $pet->gender ?? 'N/A' }}</p>
                            
                            <!-- Tombol Health History -->
                            <button type="button" class="btn btn-outline-info btn-sm mt-2"
                                    data-bs-toggle="modal"
                                    data-bs-target="#healthHistoryModal{{ $pet->id }}">
                                <i class="fa-solid fa-notes-medical me-1"></i> View Health History
                            </button>

                            <span class="badge 
                                    @if($pet->status == 'available') bg-success
                                    @elseif($pet->status == 'pending') bg-warning text-dark
                                    @else bg-secondary @endif">
                                    {{ ucfirst($pet->status) }}
                            </span>

                            <div class="mt-3">
                                <form method="POST" action="{{ route('shelter.deletepet', $pet->id) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this pet?')">
                                        <i class="fa-solid fa-trash"></i> Delete
                                    </button>
                                </form>
                                <!-- Edit Button -->
                                <button type="button" class="btn btn-sm btn-outline-primary"
                                        data-bs-toggle="modal" data-bs-target="#editPetModal{{ $pet->id }}">
                                    <i class="fa-solid fa-pen"></i> Edit
                                </button>
                                <!-- Book Appointment Button -->
                                <button type="button" class="btn btn-outline-success btn-sm mt-2"
                                        data-bs-toggle="modal"
                                        data-bs-target="#bookVetModal{{ $pet->id }}">
                                    <i class="fa-solid fa-stethoscope me-2"></i> Book Vet
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 🔹 Edit Pet Modal -->
                <div class="modal fade" id="editPetModal{{ $pet->id }}" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <form method="POST" action="{{ route('shelter.updatepet', $pet->id) }}" enctype="multipart/form-data" class="modal-content">
                        @csrf
                        @method('PUT')

                        <div class="modal-header bg-info text-white">
                            <h5 class="modal-title">Edit Pet — {{ ucfirst($pet->name) }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label class="form-label">Pet Name</label>
                                <input type="text" name="name" value="{{ $pet->name }}" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Species</label>
                                <input type="text" name="species" value="{{ $pet->species }}" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Breed</label>
                                <input type="text" name="breed" value="{{ $pet->breed }}" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Age</label>
                                <input type="number" name="age" value="{{ $pet->age }}" class="form-control">
                            </div>
                            
                            <!-- 🟢 PERBAIKAN: Mengubah input teks 'gender' menjadi dropdown -->
                            <div class="mb-3">
                                <label class="form-label">Gender</label>
                                <select name="gender" class="form-select">
                                    <option value="male" {{ in_array($pet->gender, ['male', 'laki-laki']) ? 'selected' : '' }}>Male / Laki-laki</option>
                                    <option value="female" {{ in_array($pet->gender, ['female', 'perempuan']) ? 'selected' : '' }}>Female / Perempuan</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Health Status</label>
                                <input type="text" name="medical_info" value="{{ $pet->medical_info }}" class="form-control">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="available" {{ $pet->status == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="pending" {{ $pet->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="adopted" {{ $pet->status == 'adopted' ? 'selected' : '' }}>Adopted</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Change Image</label>
                                <!-- Input 'name="photo"' ini SUDAH BENAR untuk ShelterController -->
                                <input type="file" name="photo" class="form-control" accept="image/*">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-info text-white">Update Pet</button>
                        </div>
                    </form>
                  </div>
                </div>

                <!-- 🔹 Health History Modal -->
                <div class="modal fade" id="healthHistoryModal{{ $pet->id }}" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content border-0 shadow rounded-4">
                      <div class="modal-header bg-info text-white">
                        <h5 class="modal-title">Health History — {{ ucfirst($pet->name) }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>
                      <div class="modal-body">
                        <p><strong>Current Condition:</strong> {{ $pet->medical_info ?? 'N/A' }}</p>

                        @if($pet->appointments->isNotEmpty() && $pet->appointments->whereNotNull('vet_feedback')->count() > 0)
                            <div class="border rounded p-3 bg-light">
                                <strong>🩺 Vet Feedback History:</strong>
                                <ul class="list-unstyled mt-3">
                                    @foreach($pet->appointments->sortByDesc('date') as $app)
                                        @if(!empty($app->vet_feedback))
                                            <li class="mb-3">
                                                <small>
                                                    <strong>Date:</strong> {{ \Carbon\Carbon::parse($app->date)->format('d M Y') }} <br>
                                                    <strong>Vet:</strong> {{ $app->vet->name ?? 'Unknown Vet' }} <br>
                                                    <strong>Feedback:</strong> {{ $app->vet_feedback }}
                                                </small>
                                            </li>
                                            <hr>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <p class="text-muted"><small>No previous vet feedback available.</small></p>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>

                <!-- 🔹 Vet Appointment Modal -->
                <div class="modal fade" id="bookVetModal{{ $pet->id }}" tabindex="-1" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content rounded-4 border-0 shadow">
                      <div class="modal-header bg-success text-white">
                        <h5 class="modal-title">Book Vet Appointment for {{ ucfirst($pet->name) }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>
                      <form method="POST" action="{{ route('appointments.store') }}">
                        @csrf
                        <input type="hidden" name="shelter_pet_id" value="{{ $pet->id }}">
                        <div class="modal-body">
                          <div class="mb-3">
                            <label class="form-label">Select Vet</label>
                            <select name="vet_id" class="form-select" required>
                              <option value="">-- Choose Vet --</option>
                              @foreach(\App\Models\User::where('role', 'vet')->get() as $vet)
                                <option value="{{ $vet->id }}">{{ $vet->name }} ({{ $vet->email }})</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" name="date" class="form-control" required min="{{ now()->toDateString() }}">
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Time</label>
                            <input type="time" name="time" class="form-control" required>
                          </div>
                          <div class="mb-3">
                            <label class="form-label">Message (optional)</label>
                            <textarea name="message" class="form-control"></textarea>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success w-100">Book Appointment</button>
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

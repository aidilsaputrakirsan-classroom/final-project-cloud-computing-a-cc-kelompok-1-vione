@extends('layouts.ownerpanel')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4 fw-bold text-primary">
        <i class="fa-solid fa-paw me-2"></i>My Pets
    </h2>

    <!-- 🟢 PERBAIKAN: Mengubah tombol dari link <a> menjadi pemicu Modal -->
    <div class="text-center mb-4">
        <button type="button" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#addPetModal">
            <i class="fa-solid fa-plus-circle me-2"></i> Add New Pet
        </button>
    </div>

    <div class="row">
        @forelse($pets as $pet)
            <div class="col-md-4 mb-4">
                <div class="card shadow border-0 rounded-4 h-100">
                    <div class="position-relative">
                        
                        <!-- Path 'storage/' ini SUDAH BENAR -->
                        @if($pet->photo)
                            <img src="{{ asset('storage/' . $pet->photo) }}" class="card-img-top rounded-top-4" alt="{{ $pet->pet_name }}" style="height:250px; object-fit:cover;">
                        @else
                            <img src="https://placehold.co/600x400/eeeeee/aaaaaa?text=No+Photo" class="card-img-top rounded-top-4" alt="No Photo" style="height:250px; object-fit:cover;">
                        @endif

                        <span class="badge bg-info position-absolute top-0 end-0 m-3 px-3 py-2 text-uppercase">
                            {{ ucfirst($pet->species) }}
                        </span>
                    </div>

                    <div class="card-body bg-light">
                        <h4 class="card-title text-center text-dark fw-bold">
                            {{ ucfirst($pet->pet_name) }}
                        </h4>
                        <p class="text-muted text-center mb-3">{{ ucfirst($pet->breed) }}</p>

                        <ul class="list-group list-group-flush small mb-3">
                            <li class="list-group-item"><b>Age:</b> {{ $pet->age ?? 'N/A' }} years</li>
                            <li class="list-group-item"><b>Gender:</b> {{ ucfirst($pet->gender) ?? 'N/A' }}</li>
                        </ul>

                        @if($pet->medical_info)
                            <p class="card-text text-secondary"><b>Medical Info:</b> {{ Str::limit($pet->medical_info, 60) }}</p>
                        @endif
                        
                        <!-- Riwayat Medis dari Vet -->
                        @if($pet->medicalHistories->isNotEmpty())
                            <strong class="d-block mb-2">🩺 Medical History:</strong>
                            @foreach($pet->medicalHistories->sortByDesc('created_at') as $record)
                            <div class="card mb-2 p-2 bg-white shadow-sm">
                                <small><strong>Dr. {{ $record->vet->name }}</strong> ({{ $record->created_at->format('d M Y') }})</small>
                                <p class="mb-0 small">{{ $record->notes }}</p>
                            </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="card-footer bg-white text-center border-0 pb-4">
                        <!-- Edit Button -->
                        <button class="btn btn-outline-warning btn-sm px-4" data-bs-toggle="modal" data-bs-target="#editModal{{ $pet->id }}">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                        </button>
                        <form action="{{ route('pets.destroy', $pet->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-outline-danger btn-sm px-4" onclick="return confirm('Delete this pet?')">
                                <i class="fa-solid fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- 🟡 Edit Modal -->
            <div class="modal fade" id="editModal{{ $pet->id }}" tabindex="-1" aria-labelledby="editModalLabel{{ $pet->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content rounded-4 shadow-lg">
                        <div class="modal-header bg-warning text-dark">
                            <h5 class="modal-title" id="editModalLabel{{ $pet->id }}">
                                <i class="fa-solid fa-pen-to-square me-2"></i>Edit {{ ucfirst($pet->pet_name) }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form action="{{ route('pets.update', $pet->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body bg-light">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Pet Name</label>
                                        <input type="text" name="pet_name" value="{{ old('pet_name', $pet->pet_name) }}" class="form-control" required>
                                        <x-input-error :messages="$errors->get('pet_name')" class="mt-2" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Species</label>
                                        <input type="text" name="species" value="{{ old('species', $pet->species) }}" class="form-control" required>
                                        <x-input-error :messages="$errors->get('species')" class="mt-2" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">Breed</label>
                                        <input type="text" name="breed" value="{{ old('breed', $pet->breed) }}" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">Age</label>
                                        <input type="number" name="age" value="{{ old('age', $pet->age) }}" class="form-control">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label fw-bold">Gender</label>
                                        <select name="gender" class="form-select">
                                            <option value="male" {{ old('gender', $pet->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ old('gender', $pet->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="perempuan" {{ old('gender', $pet->gender) == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                            <option value="laki-laki" {{ old('gender', $pet->gender) == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Medical Info</label>
                                        <textarea name="medical_info" class="form-control" rows="3">{{ old('medical_info', $pet->medical_info) }}</textarea>
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">Change Photo</label><br>
                                        @if($pet->photo)
                                            <img src="{{ asset('storage/' . $pet->photo) }}" width="120" class="rounded border mb-2">
                                        @endif
                                        
                                        <!-- 🟢 PERBAIKAN: Mengubah name="photo" menjadi "pet_photo" agar sesuai PetController -->
                                        <input type="file" name="pet_photo" class="form-control mt-2" accept="image/*">
                                        <x-input-error :messages="$errors->get('pet_photo')" class="mt-2" />
                                    </div>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fa-solid fa-save me-2"></i> Update Pet
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- 🟡 End Edit Modal -->

        @empty
            <div class="col-12 text-center">
                <p class="text-muted fs-5">No pets added yet.</p>
                <button type="button" class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#addPetModal">
                    <i class="fa-solid fa-plus-circle me-2"></i> Add Your First Pet
                </button>
            </div>
        @endforelse
    </div>
</div>

<!-- 🟢 BARU: Menambahkan Modal "Add Pet" yang hilang -->
<div class="modal fade" id="addPetModal" tabindex="-1" aria-labelledby="addPetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 shadow-lg">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="addPetModalLabel">
                    <i class="fa-solid fa-plus-circle me-2"></i>Add New Pet
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Formulir ini mengarah ke PetController@store -->
            <form action="{{ route('pets.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body bg-light">
                    <!-- Menampilkan error validasi -->
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Pet Name</label>
                            <input type="text" name="pet_name" class="form-control" value="{{ old('pet_name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Species</label>
                            <input type="text" name="species" class="form-control" value="{{ old('species') }}" placeholder="e.g., Dog, Cat" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Breed</label>
                            <input type="text" name="breed" class="form-control" value="{{ old('breed') }}" placeholder="e.g., Golden, Persia">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Age</label>
                            <input type="number" name="age" class="form-control" value="{{ old('age') }}" min="0">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label fw-bold">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="perempuan" {{ old('gender') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                                <option value="laki-laki" {{ old('gender') == 'laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Medical Info</label>
                            <textarea name="medical_info" class="form-control" rows="3" placeholder="Healthy, Vaccinated, etc.">{{ old('medical_info') }}</textarea>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Pet Photo</label>
                            <!-- Input 'name="pet_photo"' ini SUDAH BENAR untuk PetController -->
                            <input type="file" name="pet_photo" class="form-control" accept="image/*">
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-save me-2"></i> Save Pet
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

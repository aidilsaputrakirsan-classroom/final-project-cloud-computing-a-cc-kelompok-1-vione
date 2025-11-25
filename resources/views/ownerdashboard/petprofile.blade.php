@extends('layouts.ownerpanel')

@section('content')
<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white text-center rounded-top-4">
            <h3 class="mb-0"><i class="fa-solid fa-paw me-2"></i>Add Pet Profile</h3>
        </div>
        <div class="card-body p-4 bg-light">

            <form action="{{ route('pets.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row g-3">
                    <!-- Pet Name -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Pet Name</label>
                        <input type="text" name="pet_name" class="form-control form-control-lg" placeholder="Enter pet name" required>
                    </div>

                    <!-- Species -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Species</label>
                        <input type="text" name="species" class="form-control form-control-lg" placeholder="e.g., Dog, Cat, Bird" required>
                    </div>

                    <!-- Breed -->
                    <div class="col-md-6">
                        <label class="form-label fw-bold">Breed</label>
                        <input type="text" name="breed" class="form-control form-control-lg" placeholder="e.g., Labrador, Persian" required>
                    </div>

                    <!-- Age -->
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Age</label>
                        <input type="number" name="age" class="form-control form-control-lg" placeholder="Years" required>
                    </div>

                    <!-- Gender -->
                    <div class="col-md-3">
                        <label class="form-label fw-bold">Gender</label>
                        <select name="gender" class="form-select form-select-lg" required>
                            <option value="">Select...</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                    </div>

                    <!-- Color -->
                    {{-- <div class="col-md-6">
                        <label class="form-label fw-bold">Color</label>
                        <input type="text" name="color" class="form-control form-control-lg" placeholder="e.g., Brown, White, Black">
                    </div> --}}

                    <!-- Weight -->
                    {{-- <div class="col-md-6">
                        <label class="form-label fw-bold">Weight (kg)</label>
                        <input type="number" step="0.1" name="weight" class="form-control form-control-lg" placeholder="e.g., 5.5">
                    </div> --}}

                    <!-- Medical Info -->
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Medical Information</label>
                        <textarea name="medical_info" class="form-control form-control-lg" rows="3" placeholder="Vaccination history, allergies, etc."></textarea>
                    </div>

                    <!-- Photo -->
                    <div class="col-md-12">
                        <label class="form-label fw-bold">Pet Photo</label>
                        <input type="file" name="photo" class="form-control form-control-lg" accept="image/*">
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success btn-lg px-5">
                        <i class="fa-solid fa-floppy-disk me-2"></i> Save Pet Profile
                    </button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary btn-lg ms-2 px-5">
                        Cancel
                    </a>
                </div>
            {{-- </form> --}}
        </div>
    </div>
</div>
@endsection

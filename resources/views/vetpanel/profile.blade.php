@extends('layouts.vetpanel')

@section('content')
<div class="container mt-5">
    <h2 class="fw-bold text-center text-primary mb-4">
        <i class="fa-solid fa-user-doctor me-2"></i> Vet Profile
    </h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <form action="{{ route('vet.profile.update') }}" method="POST" enctype="multipart/form-data" class="card shadow p-4 border-0 rounded-4">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Specialization</label>
                <input type="text" name="specialization" class="form-control" value="{{ $profile->specialization ?? '' }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Experience (years)</label>
                <input type="text" name="experience" class="form-control" value="{{ $profile->experience ?? '' }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Clinic Name</label>
                <input type="text" name="clinic_name" class="form-control" value="{{ $profile->clinic_name ?? '' }}">
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Contact Number</label>
                <input type="text" name="contact_number" class="form-control" value="{{ $profile->contact_number ?? '' }}">
            </div>
<div class="mb-3">
    <label for="available_days" class="form-label">Available Days</label>
    <input type="text" name="available_days" class="form-control"
           placeholder="e.g. Monday, Tuesday, Friday"
           value="{{ $profile->available_days ?? '' }}">
</div>

<div class="mb-3">
    <label for="available_time" class="form-label">Available Time</label>
    <input type="text" name="available_time" class="form-control"
           placeholder="e.g. 10:00 AM - 5:00 PM"
           value="{{ $profile->available_time ?? '' }}">
</div>

            <div class="col-12 mb-3">
                <label class="form-label">About</label>
                <textarea name="about" class="form-control" rows="4">{{ $profile->about ?? '' }}</textarea>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Profile Photo</label>
                <input type="file" name="photo" class="form-control">
                @if(!empty($profile->photo))
                    <img src="{{ asset('storage/' . $profile->photo) }}" class="mt-3 rounded shadow" width="120">
                @endif
            </div>
        </div>

        <div class="text-center mt-4">
            <button class="btn btn-primary px-5">
                <i class="fa-solid fa-save me-2"></i> Save Changes
            </button>
        </div>
    </form>
</div>
@endsection

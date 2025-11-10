  @extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h2 class="fw-bold text-primary text-center mb-4">
        <i class="fa-solid fa-paw me-2"></i> Shelter Pets
    </h2>

    @if(session('success'))
        <div class="alert alert-success text-center">{{ session('success') }}</div>
    @endif

    <!-- Add Pet Button -->
    <div class="text-center mb-4">
        <button class="btn btn-outline-primary px-4" data-bs-toggle="modal" data-bs-target="#addPetModal">
            <i class="fa-solid fa-plus"></i> Add New Pet
        </button>
    </div>

    <!-- Cards -->
    <div class="row">
        @forelse($pets as $pet)
            <div class="col-md-4 mb-4">
                <div class="card shadow border-0 rounded-4">
                    @if($pet->photo)
                        <img src="{{ asset('storage/'.$pet->photo) }}" class="card-img-top" alt="{{ $pet->name }}" style="height:230px; object-fit:cover;">
                    @else
                        <img src="{{ asset('images/no-pet.jpg') }}" class="card-img-top" alt="No Photo" style="height:230px; object-fit:cover;">
                    @endif

                    <div class="card-body text-center">
                        <h5 class="fw-bold">{{ ucfirst($pet->name) }}</h5>
                        <p class="mb-1 text-muted">{{ ucfirst($pet->species) }}</p>
                        <p><b>Age:</b> {{ $pet->age ?? 'N/A' }} | <b>Gender:</b> {{ ucfirst($pet->gender ?? 'N/A') }}</p>
                        <p><b>Medical Info:</b> {{ $pet->medical_info ?? 'Healthy' }}</p>

                        <form method="POST" action="{{ route('shelter.pets.destroy', $pet->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm mt-2">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-center text-muted fs-5">No pets available yet.</p>
        @endforelse
    </div>
</div>

<!-- Add Pet Modal -->
<div class="modal fade" id="addPetModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="{{ route('shelter.pets.store') }}" enctype="multipart/form-data">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add New Pet</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <input type="text" name="name" class="form-control mb-2" placeholder="Pet Name" required>
          <input type="text" name="species" class="form-control mb-2" placeholder="Species" required>
          <input type="text" name="breed" class="form-control mb-2" placeholder="Breed">
          <input type="number" name="age" class="form-control mb-2" placeholder="Age">
          <select name="gender" class="form-select mb-2">
            <option value="">Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
          </select>
          <textarea name="medical_info" class="form-control mb-2" placeholder="Medical Info"></textarea>
          <input type="file" name="photo" class="form-control mb-2">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save Pet</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

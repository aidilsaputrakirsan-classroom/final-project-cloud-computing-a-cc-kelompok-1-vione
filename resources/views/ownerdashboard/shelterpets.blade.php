@extends('layouts.ownerpanel')

@section('content')
<div class="container mt-4">
  <h3 class="fw-bold text-primary">🐾 Adopt a Pet</h3>
  <hr>

  @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
  @endif

  @if($pets->isEmpty())
    <p class="text-muted">No pets available for adoption right now.</p>
  @else
  <div class="row">
    @foreach($pets as $pet)
      <div class="col-md-4 mb-4">
        <div class="card shadow border-0 rounded-4 h-100">
          <img src="{{ asset('storage/' . $pet->photo) }}" class="card-img-top" style="height:230px; object-fit:cover;">
          <div class="card-body text-center">
            <h5 class="fw-bold">{{ ucfirst($pet->name) }}</h5>
            <p class="text-muted mb-1">{{ $pet->species }} | {{ $pet->breed }}</p>
            <p><strong>Age:</strong> {{ $pet->age ?? 'N/A' }}</p>
            <p><strong>Health:</strong> {{ $pet->medical_info ?? 'Healthy' }}</p>
            <p><strong>Shelter:</strong> {{ $pet->shelter->name ?? 'Unknown' }}</p>

            <form action="{{ route('owner.adopt', $pet->id) }}" method="POST">
              @csrf
              <button type="submit" class="btn btn-success w-100">Adopt Now</button>
            </form>
          </div>
        </div>
      </div>
    @endforeach
  </div>
  @endif
</div>
@endsection

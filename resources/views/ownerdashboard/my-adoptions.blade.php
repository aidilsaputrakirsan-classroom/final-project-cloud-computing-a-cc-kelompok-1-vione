@extends('layouts.ownerpanel')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4">🐾 My Adoption Requests</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            @if($requests->isEmpty())
                <p class="text-muted text-center mb-0">No adoption requests yet.</p>
            @else
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Pet</th>
                            <th>Shelter</th>
                            <th>Request Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($requests as $index => $req)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('storage/' . $req->pet->photo) }}" alt="{{ $req->pet->name }}" width="50" class="rounded me-2">
                                    <div>
                                        <strong>{{ $req->pet->name }}</strong><br>
                                        <small class="text-muted">{{ ucfirst($req->pet->species) }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $req->shelter->name ?? 'N/A' }}</td>
                            <td>{{ $req->created_at->format('d M, Y') }}</td>
                            <td>{{ $req->status }}</td>
                            {{-- <td>
                                @if($req->status == 'Pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($req->status == 'Approved')
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td> --}}
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>
@endsection

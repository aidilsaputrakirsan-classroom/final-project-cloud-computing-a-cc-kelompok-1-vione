@extends('layouts.admin')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">🐾 Received Adoption Requests</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Pet</th>
                <th>Owner</th>
                <th>Status</th>
                <th>Requested At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($requests as $req)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <img src="{{ asset('storage/'.$req->pet->photo) }}" 
                             width="50" height="50" class="rounded me-2">
                        {{ $req->pet->name }}
                    </td>
                    <td>{{ $req->owner->name }}</td>
                    {{-- <td>{{ $req->status }}</td> --}}
                   <td>
    @if($req->status == 'pending')
        <form action="{{ route('shelter.adoption.update', ['id' => $req->id, 'status' => 'approved']) }}" method="POST" class="d-inline">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-success btn-sm">Approve</button>
        </form>
        <form action="{{ route('shelter.adoption.update', ['id' => $req->id, 'status' => 'rejected']) }}" method="POST" class="d-inline">
            @csrf
            @method('PUT')
            <button type="submit" class="btn btn-danger btn-sm">Reject</button>
        </form>
    @else
        <span class="badge 
            @if($req->status=='approved') bg-success 
            @elseif($req->status=='rejected') bg-danger 
            @else bg-warning 
            @endif">
            {{ ucfirst($req->status) }}
        </span>
    @endif
</td>

                    <td>{{ $req->created_at->format('d M Y') }}</td>
                    <td>
                        @if($req->status == 'Pending')
                            <form action="{{ route('shelter.adoption.status', [$req->id, 'Approved']) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-success btn-sm">Approve</button>
                            </form>
                            <form action="{{ route('shelter.adoption.status', [$req->id, 'Rejected']) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button class="btn btn-danger btn-sm">Reject</button>
                            </form>
                        @else
                            <em>No action</em>
                        @endif
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted">No adoption requests yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

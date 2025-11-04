@extends('layouts.auth_layout')

@section('content')
<!-- Card untuk Register -->
<div class="card shadow-lg">
    <div class="card-body p-4">
        
        <div class="text-center w-75 m-auto">
            <h4 class="text-dark-50 text-center pb-0 fw-bold">Create Account</h4>
            <p class="text-muted mb-4">Get started by creating your account.</p>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input id="name" class="form-control @error('name') is-invalid @enderror" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="new-password" />
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input id="password_confirmation" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" />
            </div>

            <!-- Role -->
            <div class="mb-3">
                <label for="role" class="form-label">Register as:</label>
                <select id="role" name="role" class="form-select @error('role') is-invalid @enderror" required>
                    <option value="">-- Select your role --</option>
                    <option value="owner" {{ old('role') == 'owner' ? 'selected' : '' }}>Pet Owner</option>
                    <option value="vet" {{ old('role') == 'vet' ? 'selected' : '' }}>Veterinarian (Doctor)</option>
                    <option value="shelter" {{ old('role') == 'shelter' ? 'selected' : '' }}>Shelter / Admin</option>
                </select>
                @error('role')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Tombol Submit -->
            <div class="d-grid mb-0 text-center">
                <button class="btn btn-primary" type="submit"> 
                    <i class="fa-solid fa-user-plus me-1"></i> Register 
                </button>
            </div>
        </form>

        <!-- Link ke Login -->
        <div class="row mt-3">
            <div class="col-12 text-center">
                <p class="text-muted">Already have account? <a href="{{ route('login') }}" class="text-primary ms-1"><b>Log In</b></a></p>
            </div>
        </div>

    </div> <!-- end card-body -->
</div> <!-- end card -->
@endsection


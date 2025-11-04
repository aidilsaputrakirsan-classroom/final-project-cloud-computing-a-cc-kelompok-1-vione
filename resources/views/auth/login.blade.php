@extends('layouts.auth_layout')

@section('content')
<!-- Card untuk Login -->
<div class="card shadow-lg">
    <div class="card-body p-4">
        
        <div class="text-center w-75 m-auto">
            <h4 class="text-dark-50 text-center pb-0 fw-bold">Sign In</h4>
            <p class="text-muted mb-4">Enter your email and password to access dashboard.</p>
        </div>

        <!-- Tampilkan Status (jika ada, misal: "password reset link sent") -->
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Alamat Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input id="email" class="form-control @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-3">
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-muted float-end"><small>Forgot your password?</small></a>
                @endif
                <label for="password" class="form-label">Password</label>
                <input id="password" class="form-control @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="current-password" />
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                    <label class="form-check-label" for="remember_me">Remember me</label>
                </div>
            </div>

            <!-- Tombol Submit -->
            <div class="d-grid mb-0 text-center">
                <button class="btn btn-primary" type="submit"> 
                    <i class="fa-solid fa-right-to-bracket me-1"></i> Log In 
                </button>
            </div>
        </form>

        <!-- Link ke Register -->
        <div class="row mt-3">
            <div class="col-12 text-center">
                <p class="text-muted">Don't have an account? <a href="{{ route('register') }}" class="text-primary ms-1"><b>Sign Up</b></a></p>
            </div>
        </div>

    </div> <!-- end card-body -->
</div> <!-- end card -->
@endsection


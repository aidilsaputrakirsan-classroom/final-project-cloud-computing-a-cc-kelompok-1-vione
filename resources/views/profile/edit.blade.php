@extends('layouts.ownerpanel')

@section('title', 'Profile')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">

            {{-- Header --}}
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h3 class="fw-bold mb-1 text-dark">
                        <i class="mdi mdi-account-cog-outline text-primary me-2"></i> My Profile
                    </h3>
                    <p class="text-muted mb-0">Manage your account information and preferences.</p>
                </div>
            </div>

            {{-- Profile Info --}}
            <div class="card border-0 shadow-sm mb-4 rounded-3">
                <div class="card-header bg-primary bg-opacity-10 border-0">
                    <div class="d-flex align-items-center">
                        <i class="mdi mdi-account-outline fs-4 text-primary me-2"></i>
                        <div>
                            <h5 class="mb-0 fw-semibold text-primary">Profile Information</h5>
                            <small class="text-muted">Update your name and email address.</small>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4 py-4">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Password Update --}}
            <div class="card border-0 shadow-sm mb-4 rounded-3">
                <div class="card-header bg-warning bg-opacity-10 border-0">
                    <div class="d-flex align-items-center">
                        <i class="mdi mdi-lock-outline fs-4 text-warning me-2"></i>
                        <div>
                            <h5 class="mb-0 fw-semibold text-warning">Change Password</h5>
                            <small class="text-muted">Make sure to use a strong password.</small>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4 py-4">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Delete Account --}}
            <div class="card border-0 shadow-sm mb-5 rounded-3">
                <div class="card-header bg-danger bg-opacity-10 border-0">
                    <div class="d-flex align-items-center">
                        <i class="mdi mdi-alert-circle-outline fs-4 text-danger me-2"></i>
                        <div>
                            <h5 class="mb-0 fw-semibold text-danger">Delete Account</h5>
                            <small class="text-muted">Once deleted, your account cannot be recovered.</small>
                        </div>
                    </div>
                </div>
                <div class="card-body px-4 py-4">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

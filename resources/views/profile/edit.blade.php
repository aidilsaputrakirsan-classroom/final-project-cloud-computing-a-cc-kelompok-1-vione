@extends('layouts.ownerpanel')

@section('title', 'Profile')

@section('content')
<div class="container-fluid py-4">
    {{-- Notifikasi Sukses --}}
    @if (session('status') === 'profile-updated')
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="mdi mdi-check-circle me-2"></i> Profil berhasil diperbarui.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10">

            {{-- Header Halaman --}}
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h3 class="fw-bold mb-1 text-dark">
                        <i class="mdi mdi-account-cog-outline text-primary me-2"></i> Profil Saya
                    </h3>
                    <p class="text-muted mb-0">Kelola informasi akun dan preferensi Anda.</p>
                </div>
            </div>

            {{-- Kartu Informasi Profil --}}
            <div class="card border-0 shadow-sm mb-4 rounded-3">
                <div class="card-header bg-primary bg-opacity-10 border-0 py-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm bg-primary bg-opacity-25 rounded-circle me-3 d-flex align-items-center justify-content-center">
                            <i class="mdi mdi-account-outline fs-4 text-primary"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-semibold text-primary">Informasi Profil</h5>
                            <small class="text-muted">Perbarui nama dan alamat email akun Anda.</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Kartu Update Password --}}
            <div class="card border-0 shadow-sm mb-4 rounded-3">
                <div class="card-header bg-warning bg-opacity-10 border-0 py-3">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm bg-warning bg-opacity-25 rounded-circle me-3 d-flex align-items-center justify-content-center">
                             <i class="mdi mdi-lock-outline fs-4 text-warning"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-semibold text-warning">Ubah Kata Sandi</h5>
                            <small class="text-muted">Pastikan akun Anda menggunakan kata sandi yang kuat agar tetap aman.</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Kartu Hapus Akun --}}
            <div class="card border-danger border-opacity-25 shadow-sm mb-5 rounded-3">
                 <div class="card-header bg-danger bg-opacity-10 border-0 py-3">
                    <div class="d-flex align-items-center">
                         <div class="avatar-sm bg-danger bg-opacity-25 rounded-circle me-3 d-flex align-items-center justify-content-center">
                            <i class="mdi mdi-alert-circle-outline fs-4 text-danger"></i>
                        </div>
                        <div>
                            <h5 class="mb-0 fw-semibold text-danger">Hapus Akun</h5>
                            <small class="text-danger text-opacity-75">Setelah akun Anda dihapus, semua sumber daya dan datanya akan dihapus secara permanen.</small>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-warning text-dark border-0 bg-warning bg-opacity-10" role="alert">
                        <i class="mdi mdi-alert me-2"></i> <strong>Peringatan:</strong> Tindakan ini tidak dapat dibatalkan. Harap pastikan Anda ingin menghapus akun ini.
                    </div>
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
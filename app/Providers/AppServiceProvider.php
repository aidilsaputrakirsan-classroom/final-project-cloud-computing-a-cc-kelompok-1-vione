<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// --- BAGIAN PENTING: IMPORT MODEL DULU DI SINI ---
use App\Models\Pet;
use App\Models\Appointment;
use App\Models\AdoptionRequest;
use App\Models\vetProfile;
use App\Observers\GeneralObserver;
// --------------------------------------------------

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Tempelkan Observer ke Model
        // Pastikan Model yang dipanggil di sini sudah di-use di atas
        Pet::observe(GeneralObserver::class);
        Appointment::observe(GeneralObserver::class);
        AdoptionRequest::observe(GeneralObserver::class);
        vetProfile::observe(GeneralObserver::class);
        
        // Catatan: Jika nanti ada error "Class AdoptionRequest not found",
        // pastikan kamu juga menambahkan 'use App\Models\AdoptionRequest;' di atas.
    }
}
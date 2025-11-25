<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AppointController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\OwnerController;
use App\Http\Controllers\PetController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShelterController;
use App\Http\Controllers\VetController;
use Illuminate\Support\Facades\Route;

// -----------------------------------------------------------------------------
// 🌐 PUBLIC ROUTES
// -----------------------------------------------------------------------------
Route::get('/', function () {
    return view('frontend.index');
})->name('home');

Route::get('/about', function () {
    return view('frontend.about');
});

Route::get('/services', function () {
    return view('frontend.services');
});

// -----------------------------------------------------------------------------
// 🔐 AUTHENTICATED COMMON ROUTES (All Roles)
// -----------------------------------------------------------------------------
Route::middleware(['auth', 'verified'])->group(function () {
    
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 📅 Booking Appointment (POST ONLY - Simpan Data)
    Route::post('/appointments', [AppointController::class, 'store'])->name('appointments.store');

    // ✅ FIX: Redirect GET /appointments ke halaman yang benar sesuai Role
    Route::get('/appointments', function () {
        $role = auth()->user()->role;
        
        if ($role === 'vet') {
            return redirect()->route('vet.appointments');
        } elseif ($role === 'shelter') {
            return redirect()->route('shelter.appointments');
        } else {
            // Default ke owner
            return redirect()->route('owner.appointments');
        }
    });
});

// -----------------------------------------------------------------------------
// 🏠 SHELTER ROUTES
// -----------------------------------------------------------------------------
Route::middleware(['auth', 'verified', 'role:shelter'])->group(function () {
    Route::get('/shelter-dashboard', [ShelterController::class, 'index'])->name('shelter.dashboard');
    
    // Pet Management
    Route::get('/shelter/add-pet', [ShelterController::class, 'create'])->name('shelter.addpet');
    Route::post('/shelter/add-pet', [ShelterController::class, 'store'])->name('shelter.storepet');
    Route::put('/shelter/update-pet/{id}', [ShelterController::class, 'update'])->name('shelter.updatepet');
    Route::delete('/shelter/delete-pet/{id}', [ShelterController::class, 'destroy'])->name('shelter.deletepet');

    // Appointments (View & Cancel)
    Route::get('/shelter/appointments', [AppointController::class, 'shelterAppointments'])->name('shelter.appointments');
    Route::put('/shelter/cancel-appointment/{id}', [AppointController::class, 'cancel'])->name('shelter.appointment.cancel');

    // Adoption Requests
    Route::get('/shelter/adoption-requests', [ShelterController::class, 'adoptionRequests'])->name('shelter.adoption.requests');
    Route::put('/shelter/adoption/{id}/{status}', [ShelterController::class, 'updateAdoptionStatus'])->name('shelter.adoption.update');
});

// -----------------------------------------------------------------------------
// 🩺 VET ROUTES
// -----------------------------------------------------------------------------
Route::middleware(['auth', 'verified', 'role:vet'])->group(function(){
    Route::get('/vet-dashboard', [VetController::class, 'index'])->name('vet.dashboard');
    
    // Profile
    Route::get('/vet/profile', [VetController::class, 'edit'])->name('vet.profile.edit');
    Route::post('/vet/profile', [VetController::class, 'update'])->name('vet.profile.update');

    // Appointments
    Route::get('/vet/appointments', [AppointController::class, 'vetAppointments'])->name('vet.appointments');
    
    // Update Status
    // PERBAIKAN: Dikembalikan ke PUT karena form browser mengirim method PUT
    Route::put('/vet/appointments/{id}/status', [AppointController::class, 'updateStatus'])->name('vet.appointment.status');
    
    // Feedback
    // Catatan: Jika form feedback juga error serupa, ubah ini juga menjadi Route::post
    Route::put('/vet/appointments/{id}/feedback', [AppointController::class, 'updateVetFeedback'])->name('vet.feedback');
});

// -----------------------------------------------------------------------------
// 👤 OWNER ROUTES
// -----------------------------------------------------------------------------
Route::middleware(['auth', 'verified', 'role:owner'])->group(function(){
    Route::get('/owner-dashboard', [OwnerController::class, 'index'])->name('owner.dashboard');

    // Pet Management
    Route::get('/Addpets', [PetController::class, 'index'])->name('pets.index');
    Route::get('/Mypets', [PetController::class, 'show'])->name('pets.show');
    Route::post('/Mypets', [PetController::class, 'store'])->name('pets.store');
    Route::put('/Mypets/{id}', [PetController::class, 'update'])->name('pets.update');
    Route::delete('/Mypets/{id}', [PetController::class, 'destroy'])->name('pets.destroy');

    // Appointments
    Route::get('/my-appointments', [AppointController::class, 'ownerAppointments'])->name('owner.appointments');
    Route::put('/cancel-appointment/{id}', [AppointController::class, 'cancel'])->name('owner.appointment.cancel');
    
    // Available Vets
    Route::get('/available-vets', [VetController::class, 'vets'])->name('owner.vets');

    // Adoption
    Route::get('/owner/shelter-pets', [OwnerController::class, 'viewShelterPets'])->name('owner.shelter.pets');
    Route::post('/owner/adopt/{id}', [OwnerController::class, 'sendAdoptionRequest'])->name('owner.adopt');
    Route::get('/owner/my-adoptions', [OwnerController::class, 'myAdoptionRequests'])->name('owner.myadoptions');
});

require __DIR__.'/auth.php';
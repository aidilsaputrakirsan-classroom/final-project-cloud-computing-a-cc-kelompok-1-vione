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

Route::get('/about', function () {
    return view('frontend.about');
});
Route::get('/services', function () {
    return view('frontend.services');
});
// admin
// Shelter Routes
// Shelter Routes
Route::middleware(['auth', 'role:shelter'])->group(function () {
    Route::get('/shelter-dashboard', [ShelterController::class, 'index'])->name('shelter.dashboard');
    Route::get('/shelter/add-pet', [ShelterController::class, 'create'])->name('shelter.addpet');
    Route::post('/shelter/add-pet', [ShelterController::class, 'store'])->name('shelter.storepet');
    Route::put('/shelter/update-pet/{id}', [ShelterController::class, 'update'])->name('shelter.updatepet');
    // ✅ Shelter appointments
    Route::get('/shelter/appointments', [AppointController::class, 'shelterAppointments'])
        ->name('shelter.appointments');

    // ✅ NEW — shelter cancel appointment route
    Route::put('/shelter/cancel-appointment/{id}', [AppointController::class, 'cancel'])
        ->name('shelter.appointment.cancel');

    Route::delete('/shelter/delete-pet/{id}', [ShelterController::class, 'destroy'])->name('shelter.deletepet');
    // Route::get('/shelter/requests', [ShelterController::class, 'requests'])->name('shelter.requests');
    // ✅ Shelter Adoption Requests
Route::get('/shelter/adoption-requests', [ShelterController::class, 'adoptionRequests'])
    ->name('shelter.adoption.requests');

// ✅ Shelter Update Status
Route::put('/shelter/adoption/{id}/{status}', [ShelterController::class, 'updateAdoptionStatus'])
    ->name('shelter.adoption.update');



});

// Common route for booking appointments (accessible by owner or shelter)
Route::middleware(['auth'])->group(function () {
    Route::post('/appointments', [AppointController::class, 'store'])->name('appointments.store');
});



// vet
Route::middleware(['auth','verified','role:vet'])->group(function(){
  Route::get('/vet-dashboard',[VetController::class,'index']);
      Route::get('/vet/profile', [VetController::class, 'edit'])->name('vet.profile.edit');
    Route::post('/vet/profile', [VetController::class, 'update'])->name('vet.profile.update');
     // Vet appointments
    Route::get('/vet/appointments', [AppointController::class, 'vetAppointments'])->name('vet.appointments');
    Route::post('/vet/appointments/{id}/status', [AppointController::class, 'updateStatus'])->name('vet.appointment.status');
   Route::put('/vet/appointments/{id}/feedback', [App\Http\Controllers\AppointController::class, 'updateVetFeedback'])
    ->name('vet.feedback')
    ->middleware('role:vet');

   
});


// owner
Route::middleware(['auth', 'verified', 'role:owner'])->group(function(){
  Route::get('/owner-dashboard',[OwnerController::class,'index']);
  Route::get('/Addpets',[PetController::class,'index'])->name('pets.index');
 Route::get('/my-appointments', [AppointController::class, 'ownerAppointments'])
    ->name('owner.appointments');

  Route::get('/Mypets',[PetController::class,'show'])->name('pets.show');
   Route::post('/Mypets',[PetController::class,'store'])->name('pets.store');
 Route::put('/Mypets/{id}',[PetController::class,'update'])->name('pets.update');
   Route::delete('/Mypets/{id}', [PetController::class, 'destroy'])->name('pets.destroy');
       Route::get('/available-vets', [VetController::class, 'vets'])->name('owner.vets');
        // Route::post('/appointments', [App\Http\Controllers\AppointController::class, 'store'])
        // ->name('appointments.store');
  Route::put('/cancel-appointment/{id}', [AppointController::class, 'cancel'])
    ->name('owner.appointment.cancel');
    // 🐾 Shelter Pets (for adoption)
Route::get('/owner/shelter-pets', [OwnerController::class, 'viewShelterPets'])->name('owner.shelter.pets');

// 📨 Send Adoption Request
Route::post('/owner/adopt/{id}', [OwnerController::class, 'sendAdoptionRequest'])->name('owner.adopt');
Route::get('/owner/my-adoptions', [OwnerController::class, 'myAdoptionRequests'])->name('owner.myadoptions');


});


Route::get('/', function () {
    return view('frontend.index');
})->name('home');


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__.'/auth.php';

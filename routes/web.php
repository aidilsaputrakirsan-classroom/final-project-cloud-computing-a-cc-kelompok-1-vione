<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DatauserController;

// User Routes with admin middleware
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/user', [DatauserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [DatauserController::class, 'create'])->name('user.create');
    Route::post('/user/add', [DatauserController::class, 'add'])->name('user.add');
    Route::get('/user/{id}/edit', [DatauserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}', [DatauserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [DatauserController::class, 'destroy'])->name('user.destroy');
});

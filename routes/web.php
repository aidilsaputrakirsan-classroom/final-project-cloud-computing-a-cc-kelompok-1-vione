<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DatauserController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\JadwallayananController;
use App\Http\Controllers\HewanController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DatahewanController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\AntrianController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\SystemMetricsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Root route
Route::get('/', function () {
    return redirect()->route('login');
});

// dashboard
Route::get('/dashboard-admin', [AdminController::class, 'index'])->name('dashboard-admin');
Route::get('/dashboard-petugas', [PetugasController::class, 'index'])->name('dashboard-petugas');
Route::get('/dashboard-hewan', [HewanController::class, 'index'])->name('dashboard-hewan');

// Simplified Layanan routes
Route::resource('layanan', LayananController::class);

// Simplified Dokter routes
Route::resource('dokter', DokterController::class);

// Jadwal Layanan
Route::get('/jadwallayanan', [JadwallayananController::class, 'index'])->name('jadwallayanan.index');
Route::get('/jadwallayanan/create', [JadwallayananController::class, 'create'])->name('jadwallayanan.create');
Route::post('/jadwallayanan/add', [JadwallayananController::class, 'add'])->name('jadwallayanan.add');
Route::get('/jadwallayanan/{id}/edit', [JadwallayananController::class, 'edit'])->name('jadwallayanan.edit');
Route::put('/jadwallayanan/update/{id}', [JadwallayananController::class, 'update'])->name('jadwallayanan.update');
Route::delete('/jadwallayanan/{id}', [JadwallayananController::class, 'destroy'])->name('jadwallayanan.destroy');

// Login routes
Route::middleware(['guest'])->group(function () {
    // Login routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Register routes
    Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [LoginController::class, 'register']);
});

// Logout route
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// User Routes with admin middleware
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/user', [DatauserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [DatauserController::class, 'create'])->name('user.create');
    Route::post('/user/add', [DatauserController::class, 'add'])->name('user.add');
    Route::get('/user/{id}/edit', [DatauserController::class, 'edit'])->name('user.edit');
    Route::put('/user/{id}', [DatauserController::class, 'update'])->name('user.update');
    Route::delete('/user/{id}', [DatauserController::class, 'destroy'])->name('user.destroy');
});

// Profile Routes - accessible by any authenticated user
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile/{id}', [ProfileController::class, 'update'])->name('profile.update');
});

// Patient Data Routes
Route::middleware('auth')->group(function () {
    // Routes accessible by admin, petugas, kepala_rs
    Route::middleware(['role:admin,petugas,kepala_rs'])->group(function () {
        Route::get('/datahewan', [DatahewanController::class, 'index'])->name('hewan.index');
        Route::delete('/datahewan/{id}', [DatahewanController::class, 'destroy'])->name('hewan.destroy');
    });
    
    // Routes for creating a new patient record (for first-time access)
    Route::get('/datapribadi/create', [DatahewanController::class, 'create'])->name('hewan.create');
    Route::post('/datapribadi', [DatahewanController::class, 'store'])->name('hewan.store');
    
    // Routes accessible by all authenticated users
    Route::get('/datapribadi/{id}', [DatahewanController::class, 'show'])->name('hewan.show');
    Route::get('/datapribadi/{id}/edit', [DatahewanController::class, 'edit'])->name('hewan.edit');
    Route::put('/datapribadi/{id}', [DatahewanController::class, 'update'])->name('hewan.update');
});

// Pendaftaran and Antrian Routes with role middleware
Route::middleware(['auth'])->group(function() {
    // Pendaftaran Routes - accessible by patients only
    Route::middleware(['role:hewan'])->group(function() {
        Route::get('/Pendaftaran', [PendaftaranController::class, 'index'])->name('Pendaftaran.index');
        Route::get('/antrian/riwayat', [AntrianController::class, 'index2'])->name('antrian.index2');
        Route::get('/pendaftaran/riwayat/pdf', [AntrianController::class, 'generatePDF'])->name('riwayat.hewan');
        
        // Add patient queue history page
        Route::get('/hewan/riwayat-antrian', [HewanController::class, 'riwayatAntrian'])->name('hewan.riwayat-antrian');
        
        // Jadwal Periksa and Riwayat Periksa routes
        Route::get('/jadwal-periksa', [HewanController::class, 'jadwalPeriksa'])->name('hewan.jadwal-periksa');
        Route::get('/riwayat-periksa', [HewanController::class, 'riwayatPeriksa'])->name('hewan.riwayat-periksa');
    });
    
    // Store route - accessible by all authenticated users
    Route::post('/Pendaftaran/store', [PendaftaranController::class, 'store'])->name('Pendaftaran.store');
    
    // Admin registration page
    Route::middleware(['role:admin,petugas'])->group(function() {
        Route::get('/admin/registration', [PendaftaranController::class, 'adminRegistration'])->name('admin.registration');
    });
    
    // Laporan Pendaftaran - accessible by admin and petugas
    Route::middleware(['role:admin,petugas'])->group(function() {
        Route::get('/antrian', [AntrianController::class, 'index'])->name('antrian.index');
    });
    
    // Generate PDF for specific appointment - accessible by all users
    Route::get('/generate-antrian/{id}', [AntrianController::class, 'generateAntrian'])->name('generate.antrian');
    
    // Rating routes
    Route::post('/rating', [RatingController::class, 'store'])->name('rating.store');
});

// Petugas Routes - accessible only by petugas
Route::middleware(['auth', 'role:petugas'])->group(function() {
    Route::get('/petugas/antrian', [PetugasController::class, 'antrianHariIni'])->name('petugas.antrian');
    Route::get('/petugas/rekam-medis/{id?}', [PetugasController::class, 'rekamMedis'])->name('petugas.rekam-medis');
    Route::post('/petugas/antrian/{id}/proses', [PetugasController::class, 'prosesAntrian'])->name('petugas.proses-antrian');
    Route::post('/petugas/antrian/{id}/selesai', [PetugasController::class, 'selesaiAntrian'])->name('petugas.selesai-antrian');
    Route::get('/petugas/riwayat-antrian', [PetugasController::class, 'riwayatAntrian'])->name('petugas.riwayat-antrian');
});

// Admin Routes for queue history
Route::middleware(['auth', 'role:admin'])->group(function() {
    // ...existing admin routes...
    Route::get('/admin/riwayat-antrian', [AdminController::class, 'riwayatAntrian'])->name('admin.riwayat-antrian');
    
    // New route for patient history
    Route::get('/admin/riwayat-hewan', [AdminController::class, 'riwayatHewan'])->name('admin.riwayat-hewan');
    Route::get('/admin/riwayat-hewan/{id}', [AdminController::class, 'detailRiwayatHewan'])->name('admin.riwayat-hewan.detail');
    Route::get('/admin/riwayat-hewan-export', [AdminController::class, 'exportRiwayatHewan'])->name('admin.riwayat-hewan.export'); Route::get('/admin/system-metrics', [SystemMetricsController::class, 'getSystemMetrics'])->name('admin.system-metrics');

});
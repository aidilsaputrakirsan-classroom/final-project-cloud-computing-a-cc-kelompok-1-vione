<?php

namespace App\Http\Controllers;

use App\Models\Datahewan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class DatahewanController extends Controller
{
    /**
     * Constructor to apply middleware
     */
    public function __construct()
    {
        // Apply auth middleware to all methods
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of patients.
     */
    public function index(Request $request)
    {
        // Check if user has permission to view all patients
        if (!in_array(Auth::user()->roles, ['admin', 'petugas', 'kepala_rs'])) {
            return redirect()->route('dashboard-hewan')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
        }
        
        // Get search input
        $search = $request->input('search');
        
        // Base query to get data for patients with role 'hewan'
        $query = Datahewan::whereHas('user', function($query) {
            $query->where('roles', 'hewan');
        });
        
        // If search term exists, filter data based on all mentioned columns
        if ($search) {
            $query->where(function($query) use ($search) {
                $query->where('nama_hewan', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('no_telp', 'like', '%' . $search . '%')
                    ->orWhere('nik', 'like', '%' . $search . '%')
                    ->orWhere('tempat_lahir', 'like', '%' . $search . '%')
                    ->orWhere('tanggal_lahir', 'like', '%' . $search . '%')
                    ->orWhere('jenis_kelamin', 'like', '%' . $search . '%')
                    ->orWhere('alamat', 'like', '%' . $search . '%')
                    ->orWhere('no_kberobat', 'like', '%' . $search . '%')
                    ->orWhere('no_kbpjs', 'like', '%' . $search . '%');
            });
        }
        
        // Get query results
        $dataHewan = $query->get();
        
        // Display view with filtered patient data
        return view('hewan.index', compact('dataHewan'));
    }
    
    /**
     * Display the specified patient.
     */
    public function show($id)
    {
        $user = Auth::user();
        
        // Define roles that have the same access rights
        $allowedRoles = ['admin', 'petugas', 'kepala_rs'];
        
        if (in_array($user->roles, $allowedRoles)) {
            // If user has one of the allowed roles, display patient data based on the given ID
            $dataHewan = Datahewan::findOrFail($id);
        } else {
            // If not one of the allowed roles, display patient data belonging to the logged-in user
            $dataHewan = Datahewan::where('user_id', $user->id)->first();
            
            if (!$dataHewan) {
                $dataHewan = new Datahewan([
                    'nama_hewan' => $user->nama_user,
                    'email' => $user->username,
                    'no_telp' => $user->no_telepon,
                    'user_id' => $user->id,
                ]);
                $dataHewan->save();
            }
            
            // Override the ID to be the ID of the logged-in user's patient record
            $id = $dataHewan->id;
            
            // Check if scan files exist in the appropriate directory
            $dataHewan->scan_ktp = $dataHewan->scan_ktp && file_exists(public_path('storage/' . $dataHewan->scan_ktp))
                ? $dataHewan->scan_ktp : null;
            $dataHewan->scan_kberobat = $dataHewan->scan_kberobat && file_exists(public_path('storage/' . $dataHewan->scan_kberobat))
                ? $dataHewan->scan_kberobat : null;
            $dataHewan->scan_kbpjs = $dataHewan->scan_kbpjs && file_exists(public_path('storage/' . $dataHewan->scan_kbpjs))
                ? $dataHewan->scan_kbpjs : null;
            $dataHewan->scan_kasuransi = $dataHewan->scan_kasuransi && file_exists(public_path('storage/' . $dataHewan->scan_kasuransi))
                ? $dataHewan->scan_kasuransi : null;
        }
        
        return view('hewan.show', compact('dataHewan', 'user'));
    }
    
    /**
     * Show the form for creating a new patient record.
     */
    public function create()
    {
        $user = Auth::user();
        
        // If admin or petugas, they can create for specific patient
        if (in_array($user->roles, ['admin', 'petugas'])) {
            // Get list of users with 'hewan' role who don't have patient data yet
            $hewanUsers = User::where('roles', 'hewan')
                ->whereNotIn('id', function($query) {
                    $query->select('user_id')
                        ->from('datahewan')
                        ->whereNotNull('user_id');
                })
                ->get();
                
            return view('hewan.create', compact('user', 'hewanUsers'));
        }
        
        // For patient themselves
        return view('hewan.create', compact('user'));
    }

    /**
     * Store a newly created patient record in storage.
     */
    public function store(Request $request)
    {
        // Validate request data - more permissive validation
        $request->validate([
            'nama_hewan' => 'required|string|max:255',
            'email' => 'required|email',
            'no_telp' => 'required|string|max:15',
            'nik' => 'nullable|string|max:16',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|in:laki-laki,perempuan',
            'alamat' => 'nullable|string',
            'no_kberobat' => 'nullable|string|max:50',
            'no_kbpjs' => 'nullable|string|max:50',
            'scan_ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'scan_kberobat' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'scan_kbpjs' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'scan_kasuransi' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $user = Auth::user();
            $userId = $user->id;
            
            // If admin/petugas is creating for another user
            if (in_array($user->roles, ['admin', 'petugas']) && $request->has('user_id')) {
                $userId = $request->user_id;
            }

            // Create new patient record
            $dataHewan = new Datahewan();
            $dataHewan->nama_hewan = $request->nama_hewan;
            $dataHewan->email = $request->email;
            $dataHewan->no_telp = $request->no_telp;
            $dataHewan->nik = $request->nik;
            $dataHewan->tempat_lahir = $request->tempat_lahir;
            $dataHewan->tanggal_lahir = $request->tanggal_lahir;
            $dataHewan->jenis_kelamin = $request->jenis_kelamin;
            $dataHewan->alamat = $request->alamat;
            $dataHewan->no_kberobat = $request->no_kberobat;
            $dataHewan->no_kbpjs = $request->no_kbpjs;
            $dataHewan->user_id = $userId;
            
            // Handle file uploads
            if ($request->hasFile('scan_ktp')) {
                $path = $request->file('scan_ktp')->store('scan_ktp', 'public');
                $dataHewan->scan_ktp = $path;
            }
            
            if ($request->hasFile('scan_kberobat')) {
                $path = $request->file('scan_kberobat')->store('scan_kberobat', 'public');
                $dataHewan->scan_kberobat = $path;
            }
            
            if ($request->hasFile('scan_kbpjs')) {
                $path = $request->file('scan_kbpjs')->store('scan_kbpjs', 'public');
                $dataHewan->scan_kbpjs = $path;
            }
            
            if ($request->hasFile('scan_kasuransi')) {
                $path = $request->file('scan_kasuransi')->store('scan_kasuransi', 'public');
                $dataHewan->scan_kasuransi = $path;
            }
            
            $dataHewan->save();

            DB::commit();

            // Redirect based on user role
            if (in_array($user->roles, ['admin', 'petugas'])) {
                return redirect()->route('hewan.index')->with('success', 'Data hewan berhasil ditambahkan');
            } else {
                return redirect()->route('hewan.show', $dataHewan->id)->with('success', 'Data hewan berhasil ditambahkan');
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Show the form for editing the specified patient.
     */
    public function edit($id)
    {
        $user = Auth::user();
        $allowedRoles = ['admin', 'petugas'];
        
        // If admin or petugas, can edit any patient record
        if (in_array($user->roles, $allowedRoles)) {
            $dataHewan = Datahewan::findOrFail($id);
        } else {
            // If patient, can only edit their own record
            $dataHewan = Datahewan::where('user_id', $user->id)->firstOrFail();
        }
        
        return view('hewan.update', compact('dataHewan'));
    }
    
    /**
     * Update the specified patient in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nik' => 'required|string|max:16',
            'tempat_lahir' => 'required|string',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'alamat' => 'required|string',
            'no_kberobat' => 'nullable|string',
            'no_kbpjs' => 'nullable|string',
            'scan_ktp' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'scan_kberobat' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'scan_kbpjs' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'scan_kasuransi' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);
        
        $user = Auth::user();
        $allowedRoles = ['admin', 'petugas']; 
        
        // If admin or petugas, can update any patient record
        if (in_array($user->roles, $allowedRoles)) {
            $dataHewan = Datahewan::findOrFail($id);
        } else {
            // If patient, can only update their own record
            $dataHewan = Datahewan::where('user_id', $user->id)->firstOrFail();
        }
        
        try {
            DB::beginTransaction();
            
            // Update basic fields
            $dataHewan->nik = $request->nik;
            $dataHewan->tempat_lahir = $request->tempat_lahir;
            $dataHewan->tanggal_lahir = $request->tanggal_lahir;
            $dataHewan->jenis_kelamin = $request->jenis_kelamin;
            $dataHewan->alamat = $request->alamat;
            $dataHewan->no_kberobat = $request->no_kberobat;
            $dataHewan->no_kbpjs = $request->no_kbpjs;
            
            // Handle file uploads
            if ($request->hasFile('scan_ktp')) {
                // Remove old file if it exists
                if ($dataHewan->scan_ktp) {
                    Storage::disk('public')->delete($dataHewan->scan_ktp);
                }
                $path = $request->file('scan_ktp')->store('scan_ktp', 'public');
                $dataHewan->scan_ktp = $path;
            }
            
            if ($request->hasFile('scan_kberobat')) {
                if ($dataHewan->scan_kberobat) {
                    Storage::disk('public')->delete($dataHewan->scan_kberobat);
                }
                $path = $request->file('scan_kberobat')->store('scan_kberobat', 'public');
                $dataHewan->scan_kberobat = $path;
            }
            
            if ($request->hasFile('scan_kbpjs')) {
                if ($dataHewan->scan_kbpjs) {
                    Storage::disk('public')->delete($dataHewan->scan_kbpjs);
                }
                $path = $request->file('scan_kbpjs')->store('scan_kbpjs', 'public');
                $dataHewan->scan_kbpjs = $path;
            }
            
            if ($request->hasFile('scan_kasuransi')) {
                if ($dataHewan->scan_kasuransi) {
                    Storage::disk('public')->delete($dataHewan->scan_kasuransi);
                }
                $path = $request->file('scan_kasuransi')->store('scan_kasuransi', 'public');
                $dataHewan->scan_kasuransi = $path;
            }
            
            $dataHewan->save();
            
            DB::commit();
            
            return redirect()->route('hewan.show', $dataHewan->id)->with('success', 'Data hewan berhasil diupdate.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }
    
    /**
     * Remove the specified patient from storage.
     */
    public function destroy($id)
    {
        // Only admin can delete patient records
        if (Auth::user()->roles !== 'admin') {
            return redirect()->route('hewan.index')->with('error', 'Anda tidak memiliki izin untuk menghapus data hewan.');
        }
        
        $dataHewan = Datahewan::findOrFail($id);
        
        // Delete associated files
        if ($dataHewan->scan_ktp) {
            Storage::disk('public')->delete($dataHewan->scan_ktp);
        }
        if ($dataHewan->scan_kberobat) {
            Storage::disk('public')->delete($dataHewan->scan_kberobat);
        }
        if ($dataHewan->scan_kbpjs) {
            Storage::disk('public')->delete($dataHewan->scan_kbpjs);
        }
        if ($dataHewan->scan_kasuransi) {
            Storage::disk('public')->delete($dataHewan->scan_kasuransi);
        }
        
        $dataHewan->delete();
        
        return redirect()->route('hewan.index')->with('success', 'Data hewan berhasil dihapus');
    }
}
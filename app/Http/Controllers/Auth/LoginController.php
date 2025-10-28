<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /** 
     * 🔹 Tampilkan halaman login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /** 
     * 🔹 Tampilkan halaman register
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /** 
     * 🔹 Proses login user (manual tanpa AuthenticatesUsers)
     */
    public function login(Request $request)
    {
        Log::info('Login attempt for email: ' . $request->email);

        // Validasi input
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        // Cek user berdasarkan email
        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Log::info('User found and password matches for user ID: ' . $user->id);

            // Login manual
            Auth::login($user, $request->filled('remember'));
            $request->session()->regenerate();

            // Redirect berdasarkan role (opsional, jika kamu sudah punya kolom roles)
            if (isset($user->roles)) {
                switch ($user->roles) {
                    case 'admin':
                        return redirect()->route('dashboard-admin');
                    case 'petugas':
                        return redirect()->route('dashboard-petugas');
                    case 'pemilik_hewan':
                        return redirect()->route('dashboard-pemilik_hewan');
                    default:
                        return redirect('/login')->with('error', 'Role tidak dikenal');
                }
            }

            // Default redirect jika belum ada kolom role
            return redirect()->route('home');
        }

        Log::warning('Failed login attempt for email: ' . $request->email);

        // Jika gagal login
        return back()
            ->withInput($request->only('email'))
            ->withErrors([
                'email' => 'Email atau password salah',
            ]);
    }

    /** 
     * 🔹 Proses register user baru
     */
    public function register(Request $request)
    {
        Log::info('Register attempt with data:', $request->except(['password', 'password_confirmation']));

        // Validasi data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'Nama tidak boleh kosong',
            'email.required' => 'Email tidak boleh kosong',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
        ]);

        if ($validator->fails()) {
            Log::error('Registration validation failed:', ['errors' => $validator->errors()->toArray()]);
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            // Simpan user baru
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            DB::commit();
            Log::info('User successfully created with ID: ' . $user->id);

            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error during registration:', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return back()->with('error', 'Terjadi kesalahan pada sistem: ' . $e->getMessage())->withInput();
        }
    }

    /** 
     * 🔹 Logout user
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}

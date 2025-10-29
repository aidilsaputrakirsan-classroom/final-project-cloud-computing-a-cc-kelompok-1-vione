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
     * Menampilkan halaman login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Menampilkan halaman register
     */
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    /**
     * Proses login pengguna
     */
    public function login(Request $request)
    {
        Log::info('Login attempt for username: ' . $request->username);

        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('username', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Log::info('User found and password matches for user ID: ' . $user->id);

            Auth::login($user, $request->filled('remember'));
            $request->session()->regenerate();

            // Redirect berdasarkan role
            switch ($user->roles) {
                case 'admin':
                    return redirect()->route('dashboard-admin');
                case 'petugas':
                    return redirect()->route('dashboard-petugas');
                case 'hewan':
                    return redirect()->route('dashboard-hewan');
                default:
                    return redirect()->route('login')->with('error', 'Role tidak dikenal');
            }
        }

        Log::warning('Failed login attempt for username: ' . $request->username);

        return back()->withInput($request->only('username'))
            ->withErrors(['username' => 'Username atau password salah']);
    }

    /**
     * Proses registrasi pengguna baru
     */
    public function register(Request $request)
    {
        Log::info('Register attempt with data:', $request->except(['password', 'password_confirmation']));

        $validator = Validator::make($request->all(), [
            'nama_user' => 'required|string|min:3|max:255',
            'username' => 'required|string|email|max:255|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
            'no_telepon' => 'required|string|min:10|max:13|regex:/^[0-9]+$/',
        ], [
            'nama_user.required' => 'Nama tidak boleh kosong',
            'nama_user.min' => 'Nama minimal 3 karakter',
            'username.required' => 'Email tidak boleh kosong',
            'username.email' => 'Format email tidak valid',
            'username.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password tidak boleh kosong',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'no_telepon.required' => 'Nomor telepon tidak boleh kosong',
            'no_telepon.min' => 'Nomor telepon minimal 10 digit',
            'no_telepon.max' => 'Nomor telepon maksimal 13 digit',
            'no_telepon.regex' => 'Nomor telepon hanya boleh angka',
        ]);

        if ($validator->fails()) {
            Log::error('Registration validation failed:', ['errors' => $validator->errors()->toArray()]);
            return back()->withErrors($validator)->withInput();
        }

        try {
            DB::beginTransaction();

            $user = User::create([
                'nama_user' => $request->nama_user,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'no_telepon' => $request->no_telepon,
                'roles' => 'hewan', // default role
            ]);

            DB::commit();
            Log::info('User successfully created with ID: ' . $user->id);

            return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error during registration:', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return back()->with('error', 'Terjadi kesalahan pada sistem: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Logout dan invalidate session
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}

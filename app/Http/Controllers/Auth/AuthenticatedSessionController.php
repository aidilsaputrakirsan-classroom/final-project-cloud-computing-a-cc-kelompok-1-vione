<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();

        $request->session()->regenerate();

        // ===================================================
        // LOGIKA REDIRECT BERDASARKAN ROLE
        // ===================================================
        
        $role = Auth::user()->role; // Ambil role user yang baru login
        $url = '/'; // Default url (jika tidak punya role)

        // 1. Cek apakah Super Admin?
        if ($role === 'super_admin') {
            $url = '/activity-logs';
        } 
        // 2. Cek Owner
        elseif ($role === 'owner') {
            $url = '/owner-dashboard';
        } 
        // 3. Cek Vet (Dokter)
        elseif ($role === 'vet') {
            $url = '/vet-dashboard';
        } 
        // 4. Cek Shelter
        elseif ($role === 'shelter') {
            $url = '/shelter-dashboard';
        }

        return redirect()->intended($url);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
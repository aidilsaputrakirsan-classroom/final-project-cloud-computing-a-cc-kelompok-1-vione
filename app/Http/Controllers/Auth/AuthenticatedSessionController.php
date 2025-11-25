<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Route;

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
        // INILAH LOGIKA YANG HILANG YANG KITA TAMBAHKAN
        // ===================================================
        $url = '';
        if(Auth::user()->role === 'owner'){
            $url = '/owner-dashboard';
        } elseif(Auth::user()->role === 'vet'){
            $url = '/vet-dashboard';
        } elseif(Auth::user()->role === 'shelter'){
            $url = '/shelter-dashboard';
        } else {
            // Jika tidak punya role, arahkan ke halaman utama
            $url = '/';
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

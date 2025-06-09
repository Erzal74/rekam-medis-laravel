<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Controllers\Controller;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ], [
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // Regenerate session ID to prevent session fixation attacks
            $request->session()->regenerate();

            if ($user->role === 'admin') {
                $request->session()->flash('show_welcome_popup', true);
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'dokter') {
                $request->session()->flash('show_welcome_popup', true);
                return redirect()->route('dokter.dashboard');
            } else {
                Auth::logout();
                $request->session()->invalidate(); // Invalidate session
                $request->session()->regenerateToken(); // Regenerate CSRF token
                return redirect()->route('login')->with('error', 'Role pengguna tidak dikenali.');
            }
        }

        // Jika Auth::attempt gagal (kredensial tidak cocok)
        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ])->withInput($request->only('username')); // Agar username tidak hilang setelah error
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Logout pengguna

        $request->session()->invalidate(); // Menghancurkan semua data sesi
        $request->session()->regenerateToken(); // Membuat token CSRF baru untuk keamanan

        // Redirect ke halaman login dengan pesan sukses (opsional)
        return redirect()->route('login')->with('success', 'Anda berhasil logout.');
    }
}

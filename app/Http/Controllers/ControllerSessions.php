<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ControllerSessions extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'role'     => 'required',
        ], [
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi',
            'role.required'     => 'Role wajib diisi',
        ]);

        // Cek apakah username ditemukan
        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return redirect('/')
                ->withErrors(['username' => 'Username tidak ditemukan.'])
                ->withInput();
        }

        // Cek password
        if (!Hash::check($request->password, $user->password)) {
            return redirect('/')
                ->withErrors(['password' => 'Password salah.'])
                ->withInput();
        }

        // Cek role
        if ($user->role !== $request->role) {
            return redirect('/')
                ->withErrors(['role' => 'Role tidak sesuai.'])
                ->withInput();
        }

        // Jika semua valid, login
        Auth::login($user);

        // Redirect sesuai role
        return $user->role === 'admin'
            ? redirect('/admin/dashboard') // Perbaiki redirect ke /admin/dashboard
            : redirect('/dokter/dashboard');
    }

    function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}

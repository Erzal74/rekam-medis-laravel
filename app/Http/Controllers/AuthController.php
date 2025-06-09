<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Tambahkan ini jika Anda menggunakan Hash::check di sini
use App\Models\User; // Tambahkan ini jika Anda mengambil user berdasarkan username secara manual

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login'); // Menampilkan halaman login (pastikan ada file: resources/views/login.blade.php)
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ], [
            'username.required' => 'Username wajib diisi',
            'password.required' => 'Password wajib diisi',
        ]);

        // Opsional: Jika Anda ingin validasi username/password secara manual seperti di ControllerSessions
        // Jika tidak, biarkan Auth::attempt yang menanganinya
        $user = User::where('username', $request->username)->first();

        if (!$user) {
            return redirect()->route('login') // Arahkan ke rute login
                ->withErrors(['username' => 'Username tidak ditemukan.'])
                ->withInput();
        }

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->route('login') // Arahkan ke rute login
                ->withErrors(['password' => 'Password salah.'])
                ->withInput();
        }

        // --- Bagian Penting untuk Autentikasi dan Redirect ---
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            $user = Auth::user();

            if ($user->role === 'admin') {
                // Set flash session untuk popup welcome
                $request->session()->flash('show_welcome_popup', true); // <--- INI PENTING
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'dokter') {
                // Untuk dokter, mungkin tidak perlu popup, atau bisa ditambahkan jika mau
                // $request->session()->flash('show_welcome_popup_dokter', true); // Contoh untuk dokter
                return redirect()->route('dokter.dashboard');
            } else {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Role pengguna tidak dikenali.');
            }
        }

        // Ini adalah fallback jika Auth::attempt gagal (misalnya karena kredensial tidak cocok
        // meskipun validasi manual di atas sudah dilewati, yang seharusnya jarang terjadi)
        return redirect()->route('login')->with('error', 'Username atau password salah.');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Berhasil logout.');
    }
}

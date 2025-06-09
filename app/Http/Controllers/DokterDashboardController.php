<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Kunjungan;
use App\Models\Todo;
use Carbon\Carbon;

class DokterDashboardController extends Controller
{
    public function index()
    {
        $dokter = Auth::user();
        $hariIni = Carbon::today();

        $jumlahPasienHariIni = Kunjungan::where('dokter_id', $dokter->id)
            ->whereDate('waktu_kunjungan', $hariIni)
            ->count();

        $jumlahPasienLamaHariIni = Kunjungan::where('dokter_id', $dokter->id)
            ->whereDate('waktu_kunjungan', $hariIni)
            ->where('is_baru', false)
            ->count();

        $jumlahPasienBaruHariIni = Kunjungan::where('dokter_id', $dokter->id)
            ->whereDate('waktu_kunjungan', $hariIni)
            ->where('is_baru', true)
            ->count();

        $jadwalKunjunganHariIni = Kunjungan::where('dokter_id', $dokter->id)
            ->whereDate('waktu_kunjungan', $hariIni)
            ->orderBy('waktu_kunjungan', 'asc')
            ->with('pasien') // Eager load relasi pasien
            ->get();

        $todoList = Todo::where('dokter_id', $dokter->id)
            ->where('selesai', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dokter.dashboard', compact(
            'dokter',
            'jumlahPasienHariIni',
            'jumlahPasienLamaHariIni',
            'jumlahPasienBaruHariIni',
            'jadwalKunjunganHariIni',
            'todoList'
        ));
    }

    public function storeTodo(Request $request)
    {
        $request->validate([
            'deskripsi' => 'required|max:255',
        ], [
            'deskripsi.required' => 'Harap isi catatan.', // Pesan error kustom
        ]);

        Todo::create([
            'dokter_id' => Auth::id(),
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('dokter.dashboard')->with('success', 'Catatan berhasil ditambahkan.');
    }

    public function editTodo(Todo $todo)
    {
        if ($todo->dokter_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit catatan ini.');
        }
        return view('dokter.edit-todo', compact('todo'));
    }

    public function updateTodo(Request $request, Todo $todo)
    {
        if ($todo->dokter_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengupdate catatan ini.');
        }

        $request->validate([
            'deskripsi' => 'required|max:255',
        ], [
            'deskripsi.required' => 'Harap isi catatan.',
        ]);

        $todo->update([
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('dokter.dashboard')->with('success', 'Catatan berhasil diperbarui.');
    }

    public function destroyTodo(Todo $todo)
    {
        if ($todo->dokter_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus catatan ini.');
        }

        $todo->delete();

        return redirect()->route('dokter.dashboard')->with('success', 'Catatan berhasil dihapus.');
    }
}

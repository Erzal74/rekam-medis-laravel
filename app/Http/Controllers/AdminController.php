<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\DoctorSchedule;
use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

// Pengecekan role DILAKUKAN di DALAM metode controller ini
// karena tidak ada middleware role spesifik di rute.
class AdminController extends Controller
{
    public function index()
    {
        // Pengecekan role: Pastikan pengguna login DAN memiliki role 'admin'
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/home')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }

        // Dashboard Logic
        $totalPasien = Pasien::count();
        $totalKunjungan = Kunjungan::count();

        // Riwayat kunjungan (6 bulan terakhir)
        $riwayatKunjungan = Kunjungan::select(
            DB::raw('DATE_FORMAT(waktu_kunjungan, "%Y-%m") as group_key'),
            DB::raw('DATE_FORMAT(waktu_kunjungan, "%M") as bulan'),
            DB::raw('count(*) as jumlah')
        )
            ->where('waktu_kunjungan', '>=', now()->subMonths(6))
            ->groupBy('group_key', 'bulan')
            ->orderBy('group_key')
            ->get()
            ->toArray();

        // Grafik kunjungan (4 bulan terakhir)
        $grafikKunjungan = Kunjungan::select(
            DB::raw('DATE_FORMAT(waktu_kunjungan, "%Y-%m") as group_key'),
            DB::raw('DATE_FORMAT(waktu_kunjungan, "%b") as bulan'),
            DB::raw('count(*) as jumlah')
        )
            ->where('waktu_kunjungan', '>=', now()->subMonths(4))
            ->groupBy('group_key', 'bulan')
            ->orderBy('group_key')
            ->get()
            ->toArray();

        return view('admin.dashboard_content', compact(
            'totalPasien',
            'totalKunjungan',
            'riwayatKunjungan',
            'grafikKunjungan'
        ));
    }

    /**
     * Fungsi-fungsi untuk manajemen Pasien - Cek role DIKEMBALIKAN di setiap fungsi ini
     */
    public function pasienIndex()
    {
        // Pengecekan role DIKEMBALIKAN
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/home')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }
        $pasiens = Pasien::latest()->paginate(10);
        return view('admin.pasien.index', compact('pasiens'));
    }

    public function pasienCreate()
    {
        // Pengecekan role DIKEMBALIKAN
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/home')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }
        return view('admin.pasien.create');
    }

    public function pasienStore(Request $request)
    {
        // Pengecekan role DIKEMBALIKAN
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/home')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }
        $request->validate([
            'nama' => 'required',
            'tempat_lahir' => 'nullable',
            'tanggal_lahir' => 'nullable|date',
            'tanggal_berkunjung' => 'nullable|date',
            'alamat' => 'required',
            'no_hp' => 'required',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'status' => 'nullable',
            // 'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Hapus validasi foto_ktp
        ]);

        $pasienData = $request->all(); // Ambil semua input

        // if ($request->hasFile('foto_ktp')) { // Hapus bagian upload foto_ktp
        //     $fotoKTP = $request->file('foto_ktp');
        //     $namaFile = time() . '_' . $fotoKTP->getClientOriginalName();
        //     $fotoKTP->storeAs('public/foto_ktp', $namaFile);
        //     $pasienData['foto_ktp'] = $namaFile;
        // }

        Pasien::create($pasienData);

        return redirect()->route('admin.pasien.index')->with('success', 'Data pasien berhasil ditambahkan.');
    }

    public function pasienEdit(Pasien $pasien)
    {
        // Pengecekan role DIKEMBALIKAN
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/home')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }
        return view('admin.pasien.edit', compact('pasien'));
    }

    public function pasienUpdate(Request $request, Pasien $pasien)
    {
        // Pengecekan role DIKEMBALIKAN
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/home')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }
        $request->validate([
            'nama' => 'required',
            'tempat_lahir' => 'nullable',
            'tanggal_lahir' => 'nullable|date',
            'tanggal_berkunjung' => 'nullable|date',
            'alamat' => 'required',
            'no_hp' => 'required',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'status' => 'nullable',
            // 'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Hapus validasi foto_ktp
        ]);

        $pasienData = $request->all(); // Ambil semua input

        $pasien->update($pasienData);

        return redirect()->route('admin.pasien.index')->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function pasienDestroy(Pasien $pasien)
    {
        // Pengecekan role DIKEMBALIKAN
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/home')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }

        $pasien->delete();

        return redirect()->route('admin.pasien.index')->with('success', 'Data pasien berhasil dihapus.');
    }

    /**
     * Fungsi-fungsi untuk manajemen Jadwal Dokter - Cek role DIKEMBALIKAN di setiap fungsi ini
     */
    public function scheduleIndex()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/home')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        }
        // Ambil semua jadwal dokter, diurutkan terbaru dengan pagination
        $schedules = DoctorSchedule::with('doctor')->latest()->paginate(10);
        return view('admin.schedules.index', compact('schedules'));
    }

    // Fungsi scheduleCreate, scheduleStore, scheduleEdit, scheduleUpdate, scheduleDestroy DIBUANG
}

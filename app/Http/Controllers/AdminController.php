<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\DoctorSchedule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{

    public function index()
    {

        $totalPasien = Pasien::count();
        $totalKunjungan = Kunjungan::count();

        // Riwayat kunjungan (hanya untuk hari ini)
        $riwayatKunjungan = Kunjungan::select(
                DB::raw('DATE_FORMAT(kunjungans.waktu_kunjungan, "%H:%i") as jam_kunjungan'),
                'pasiens.nama as nama_pasien',
                'kunjungans.id'
            )
            ->join('pasiens', 'kunjungans.pasien_id', '=', 'pasiens.id')
            ->whereDate('kunjungans.waktu_kunjungan', today())
            ->orderBy('kunjungans.waktu_kunjungan', 'desc')
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

    public function pasienIndex()
    {
        $pasiens = Pasien::latest()->paginate(10);
        return view('admin.pasien.index', compact('pasiens'));
    }

    public function pasienCreate()
    {

        $doctors = User::where('role', 'dokter')->get();

        return view('admin.pasien.create', compact('doctors'));
    }

    public function pasienStore(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'tempat_lahir' => 'nullable',
            'tanggal_lahir' => 'nullable|date',
            'tanggal_berkunjung' => 'nullable|date',
            'alamat' => 'required',
            'no_hp' => 'required',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'status' => 'nullable',
        ]);

        $pasien = Pasien::create($request->all());

        $defaultDokterId = 1;

        Kunjungan::create([
            'pasien_id' => $pasien->id,
            'dokter_id' => $defaultDokterId,
            'waktu_kunjungan' => now(),
            'is_baru' => true,
        ]);

        return redirect()->route('admin.pasien.index')->with('success', 'Data pasien berhasil ditambahkan.');
    }

    public function pasienEdit(Pasien $pasien)
    {
        return view('admin.pasien.edit', compact('pasien'));
    }

    public function pasienUpdate(Request $request, Pasien $pasien)
    {
        $request->validate([
            'nama' => 'required',
            'tempat_lahir' => 'nullable',
            'tanggal_lahir' => 'nullable|date',
            'tanggal_berkunjung' => 'nullable|date',
            'alamat' => 'required',
            'no_hp' => 'required',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'status' => 'nullable',
        ]);

        $pasien->update($request->all());

        return redirect()->route('admin.pasien.index')->with('success', 'Data pasien berhasil diperbarui.');
    }

    public function pasienDestroy(Pasien $pasien)
    {

        $pasien->delete();

        return redirect()->route('admin.pasien.index')->with('success', 'Data pasien berhasil dihapus.');
    }

    public function scheduleIndex()
    {
        $schedules = DoctorSchedule::with('doctor')->latest()->paginate(10);
        return view('admin.schedules.index', compact('schedules'));
    }
}

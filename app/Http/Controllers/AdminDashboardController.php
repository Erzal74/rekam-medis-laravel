<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\Pasien;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Ambil total pasien dari tabel pasiens
        $totalPasien = Pasien::count();

        // Ambil total kunjungan dari tabel kunjungans
        $totalKunjungan = Kunjungan::count();

        // Ambil riwayat kunjungan per bulan (contoh 6 bulan terakhir)
        $riwayatKunjungan = Kunjungan::select(DB::raw('DATE_FORMAT(waktu_kunjungan, "%M") as bulan'), DB::raw('count(*) as jumlah'))
            ->where('waktu_kunjungan', '>=', now()->subMonths(6))
            ->groupBy(DB::raw('DATE_FORMAT(waktu_kunjungan, "%M")'))
            ->orderBy('waktu_kunjungan')
            ->get()
            ->toArray();

        // Ambil data grafik kunjungan (contoh 4 bulan terakhir)
        $grafikKunjungan = Kunjungan::select(DB::raw('DATE_FORMAT(waktu_kunjungan, "%b") as bulan'), DB::raw('count(*) as jumlah'))
            ->where('waktu_kunjungan', '>=', now()->subMonths(4))
            ->groupBy(DB::raw('DATE_FORMAT(waktu_kunjungan, "%b")'))
            ->orderBy('waktu_kunjungan')
            ->get()
            ->toArray();

        return view('admin.dashboard', compact('totalPasien', 'totalKunjungan', 'riwayatKunjungan', 'grafikKunjungan'));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\Kunjungan;
use App\Models\Pasien;
use App\Models\CatatanMedis;
use App\Models\Odontogram;
use App\Models\RekamMedis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class DokterController extends Controller
{
    // Hapus konstruktor jika Anda menggunakan middleware di routes/web.php
    // public function __construct() {
    //     $this->middleware('auth'); // Ini sudah dihandle oleh routes/web.php
    //     $this->middleware('role:dokter'); // Ini juga sudah dihandle oleh routes/web.php
    // }

    public function index()
    {
        // Cek autentikasi dan role sudah ditangani oleh middleware di routes/web.php
        $user = Auth::user();
        $hariIni = Carbon::today();

        // Hitung jumlah pasien yang berkunjung hari ini
        $jumlahPasienHariIni = Kunjungan::where('dokter_id', $user->id)
            ->whereDate('waktu_kunjungan', $hariIni)
            ->distinct('pasien_id')
            ->count();

        // Ambil jadwal kunjungan pasien hari ini
        $jadwalKunjunganHariIni = Kunjungan::where('dokter_id', $user->id)
            ->whereDate('waktu_kunjungan', $hariIni)
            ->orderBy('waktu_kunjungan', 'asc')
            ->with('pasien')
            ->get();

        $todoList = Todo::where('dokter_id', Auth::id())
            ->where('selesai', false)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dokter.dashboard_content', compact(
            'user',
            'jumlahPasienHariIni',
            'jadwalKunjunganHariIni',
            'todoList'
        ));
    }

    // Perhatikan: pasienStore di DokterController ini terlihat seperti duplikasi dari AdminController.
    // Jika hanya admin yang bisa menambahkan pasien, hapus fungsi ini dari DokterController.
    // Atau jika dokter juga bisa, pastikan role check sesuai di middleware.
    public function pasienStore(Request $request)
    {
        // Kode otentikasi ini dihapus, sudah di middleware
        // if (!Auth::check() || Auth::user()->role !== 'admin') { // Perhatikan: ini memeriksa role admin di dokter controller
        //     return redirect('/home')->with('error', 'Anda tidak memiliki akses ke halaman admin.');
        // }
        // ... (sisanya sama)
        $request->validate([
            'nama' => 'required',
            'tempat_lahir' => 'nullable',
            'tanggal_lahir' => 'nullable|date',
            'tanggal_berkunjung' => 'nullable|date',
            'alamat' => 'required',
            'no_hp' => 'required',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'status' => 'nullable',
            'dokter_id' => 'nullable|exists:users,id', // Pastikan ada input untuk memilih dokter (opsional)
        ]);

        $pasien = Pasien::create($request->all());

        // Membuat kunjungan saat pasien ditambahkan
        $dokterIdUntukKunjungan = $request->input('dokter_id'); // Ambil ID dokter dari input form

        // Jika tidak ada dokter yang dipilih, Anda bisa menggunakan ID default atau logika lain
        if (!$dokterIdUntukKunjungan) {
            $dokterIdUntukKunjungan = Auth::id(); // Contoh: gunakan ID dokter yang sedang login
            // ATAU
            // $dokterIdUntukKunjungan = 1; // Contoh: gunakan ID dokter default
        }

        Kunjungan::create([
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokterIdUntukKunjungan,
            'waktu_kunjungan' => now(), // Atur waktu kunjungan saat ini
            'is_baru' => true, // Atau sesuaikan logika Anda
        ]);

        // Perbaikan redirect: seharusnya ke rute dokter atau halaman pasien dokter
        return redirect()->route('dokter.dashboard')->with('success', 'Data pasien berhasil ditambahkan.');
    }

    public function jadwalSaya()
    {
        return view('dokter.jadwal_saya');
    }

    public function storeTodo(Request $request)
    {
        $request->validate([
            'deskripsi' => 'required|max:255',
        ], [
            'deskripsi.required' => 'Harap isi catatan.',
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

    public function daftarCatatanMedis()
    {
        $dokterId = Auth::id();
        $catatanMedis = CatatanMedis::where('dokter_id', $dokterId)
            ->with('pasien')
            ->latest()
            ->paginate(10);

        return view('dokter.catatan_medis.index', compact('catatanMedis'));
    }

    public function createCatatanMedis()
    {
        $pasiens = Pasien::all();
        return view('dokter.catatan_medis.create', compact('pasiens'));
    }

    public function storeCatatanMedis(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'tanggal_pemeriksaan' => 'required|date',
            'keluhan_utama' => 'required',
            'diagnosa' => 'nullable',
            'tindakan' => 'nullable',
            'resep' => 'nullable',
        ]);

        $dokterId = Auth::id();

        CatatanMedis::create([
            'dokter_id' => $dokterId,
            'pasien_id' => $request->pasien_id,
            'tanggal_pemeriksaan' => $request->tanggal_pemeriksaan,
            'keluhan_utama' => $request->keluhan_utama,
            'diagnosa' => $request->diagnosa,
            'tindakan' => $request->tindakan,
            'resep' => $request->resep,
        ]);

        return redirect()->route('dokter.catatan_medis.index')->with('success', 'Catatan Medis Berhasil Ditambahkan');
    }

    public function showCatatanMedis(CatatanMedis $catatanMedis)
    {
        // Pastikan dokter hanya bisa melihat catatan medisnya sendiri
        if ($catatanMedis->dokter_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk melihat catatan medis ini.');
        }
        return view('dokter.catatan_medis.show', compact('catatanMedis'));
    }

    public function editCatatanMedis(CatatanMedis $catatanMedis)
    {
        // Pastikan dokter hanya bisa mengedit catatan medisnya sendiri
        if ($catatanMedis->dokter_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit catatan medis ini.');
        }
        return view('dokter.catatan_medis.edit', compact('catatanMedis'));
    }

    public function updateCatatanMedis(Request $request, CatatanMedis $catatanMedis)
    {
        // Pastikan dokter hanya bisa mengupdate catatan medisnya sendiri
        if ($catatanMedis->dokter_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengupdate catatan medis ini.');
        }
        $request->validate([
            'tanggal_pemeriksaan' => 'required|date',
            'keluhan_utama' => 'required',
            'diagnosa' => 'nullable',
            'tindakan' => 'nullable',
            'resep' => 'nullable',
        ]);

        $catatanMedis->update([
            'tanggal_pemeriksaan' => $request->tanggal_pemeriksaan,
            'keluhan_utama' => $request->keluhan_utama,
            'diagnosa' => $request->diagnosa,
            'tindakan' => $request->tindakan,
            'resep' => $request->resep,
        ]);

        return redirect()->route('dokter.catatan_medis.show', $catatanMedis->id)->with('success', 'Catatan Medis Berhasil diubah');
    }

    public function destroyCatatanMedis(CatatanMedis $catatanMedis)
    {
        // Pastikan dokter hanya bisa menghapus catatan medisnya sendiri
        if ($catatanMedis->dokter_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus catatan medis ini.');
        }
        $catatanMedis->delete();
        return redirect()->route('dokter.catatan_medis.index')->with('success', 'Catatan Medis Berhasil dihapus');
    }

    public function rekamMedisIndex()
    {
        return view('dokter.rekam_medis.index');
    }

    public function rekamMedisShow(Request $request)
    {
        $request->validate([
            'nama_pasien' => 'required|string|max:255',
        ]);

        $namaPasien = $request->input('nama_pasien');

        $pasien = Pasien::where('nama', 'like', '%' . $namaPasien . '%')->first();

        if (!$pasien) {
            return redirect()->route('dokter.rekam_medis.index')->with('error', 'Pasien dengan nama tersebut tidak ditemukan.');
        }

        // Pastikan hanya menampilkan catatan medis yang terkait dengan dokter yang sedang login
        $catatanMedis = CatatanMedis::where('pasien_id', $pasien->id)
            ->where('dokter_id', Auth::id()) // Tambahkan filter dokter_id
            ->orderBy('tanggal_pemeriksaan', 'desc')
            ->get();

        // Pastikan hanya menampilkan odontogram yang terkait dengan dokter yang sedang login
        $odontograms = Odontogram::where('pasien_id', $pasien->id)
            ->where('dokter_id', Auth::id()) // Tambahkan filter dokter_id
            ->orderBy('tanggal_pemeriksaan', 'desc')
            ->get();

        return view('dokter.rekam_medis.show', compact('pasien', 'catatanMedis', 'odontograms'));
    }

    public function cetakPdfRekamMedis($pasienId)
    {
    $pasien = Pasien::findOrFail($pasienId);
    $catatanMedis = CatatanMedis::where('pasien_id', $pasienId)
        ->where('dokter_id', Auth::id()) // Filter by logged in doctor
        ->orderBy('tanggal_pemeriksaan', 'desc')->get();
    $odontograms = Odontogram::where('pasien_id', $pasienId)
        ->where('dokter_id', Auth::id()) // Filter by logged in doctor
        ->orderBy('tanggal_pemeriksaan', 'desc')->get();

    // Path ke file gambar (pastikan ini benar)
    $imagePath = public_path('images/odontogram_chart.jpeg');
    $odontogramChartBase64 = null;

    if (File::exists($imagePath)) {
        $imageData = file_get_contents($imagePath);
        $odontogramChartBase64 = base64_encode($imageData);
    }

    $data = [
        'pasien' => $pasien,
        'catatanMedis' => $catatanMedis,
        'odontograms' => $odontograms,
        'odontogramChartBase64' => $odontogramChartBase64,
    ];

    $pdf = Pdf::loadView('dokter.rekam_medis.pdf', $data);
    return $pdf->download('rekam-medis-' . str_replace(' ', '-', strtolower($pasien->nama)) . '.pdf');
    }

    public function indexOdontogram()
    {
        $odontograms = Odontogram::where('dokter_id', Auth::id())->get();
        return view('dokter.odontograms.index', compact('odontograms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createOdontogram()
    {
        $pasiens = Pasien::all();
        return view('dokter.odontograms.create', compact('pasiens'));
    }

    public function storeOdontogram(Request $request)
    {
    $request->validate([
        'pasien_id' => 'required|exists:pasiens,id',
        'tanggal_pemeriksaan' => 'required|date',
        'nomor_gigi' => 'required',
        'kondisi_gigi' => 'required',
    ]);

    $odontogram = new Odontogram();
    $odontogram->dokter_id = Auth::id();
    $odontogram->pasien_id = $request->input('pasien_id');
    $odontogram->tanggal_pemeriksaan = $request->input('tanggal_pemeriksaan');
    $odontogram->nomor_gigi = $request->input('nomor_gigi');
    $odontogram->kondisi_gigi = $request->input('kondisi_gigi');
    $odontogram->occlusi = $request->input('occlusi');
    $odontogram->torus_palatinus = $request->input('torus_palatinus');
    $odontogram->torus_mandibularis = $request->input('torus_mandibularis');
    $odontogram->palatum = $request->input('palatum');
    $odontogram->diastema = $request->input('diastema');
    $odontogram->gigi_anomali = $request->input('gigi_anomali');
    $odontogram->lain_lain = $request->input('lain_lain');
    $odontogram->jumlah_foto_rontgen = $request->input('jumlah_foto_rontgen');
    $odontogram->save();

    // Cari atau buat rekam medis pasien
    $rekamMedis = RekamMedis::firstOrCreate(
        ['pasien_id' => $request->input('pasien_id')],
        ['tanggal_pembuatan' => now(), 'status' => 'aktif', 'nomor_rm' => 'RM-' . time()]   // Generate nomor_rm
    );

    // Update informasi odontogram di rekam medis
    $rekamMedis->update([
        'tanggal_pemeriksaan_gigi' => $request->input('tanggal_pemeriksaan'),
        'nomor_gigi' => $request->input('nomor_gigi'),
        'kondisi_gigi' => $request->input('kondisi_gigi'),
        'occlusi' => $request->input('occlusi'),
        'torus_palatinus' => $request->input('torus_palatinus'),
        'torus_mandibularis' => $request->input('torus_mandibularis'),
        'palatum' => $request->input('palatum'),
        'diastema' => $request->input('diastema'),
        'gigi_anomali' => $request->input('gigi_anomali'),
        'lain_lain' => $request->input('lain_lain'),
        'jumlah_foto_rontgen' => $request->input('jumlah_foto_rontgen'),
        // Update kolom lain yang relevan
    ]);

    return redirect()->route('dokter.odontograms.index')->with('success', 'Odontogram berhasil disimpan dan informasi gigi telah ditambahkan ke rekam medis pasien.');
    }

    /**
     * Display the specified resource.
     */
    public function showOdontogram(Odontogram $odontogram)
    {
        if ($odontogram->dokter_id != Auth::id()) {
            abort(403); // Hanya dokter yang membuat yang bisa melihat
        }
        return view('dokter.odontograms.show', compact('odontogram'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function editOdontogram($id)
    {
        $odontogram = Odontogram::find($id);

        if (!$odontogram) {
            // Handle jika odontogram tidak ditemukan, misalnya redirect ke halaman index dengan pesan error
            return redirect()->route('dokter.odontograms.index')->with('error', 'Data odontogram tidak ditemukan.');
        }
        // Pastikan dokter hanya bisa mengedit odontogramnya sendiri
        if ($odontogram->dokter_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk mengedit odontogram ini.');
        }

        $pasiens = Pasien::all();
        return view('dokter.odontograms.edit', compact('odontogram', 'pasiens'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function updateOdontogram(Request $request, Odontogram $odontogram)
    {
        // Pastikan dokter hanya bisa mengupdate odontogramnya sendiri
        if ($odontogram->dokter_id !== Auth::id()) { // Gunakan Auth::id() langsung
            abort(403, 'Anda tidak memiliki akses untuk mengupdate odontogram ini.');
        }
        $request->validate([
            'tanggal_pemeriksaan' => 'required|date',
            'nomor_gigi' => 'required',
            'kondisi_gigi' => 'required',
            // Tambahkan validasi untuk kolom lain
        ]);

        $odontogram->tanggal_pemeriksaan = $request->input('tanggal_pemeriksaan');
        $odontogram->nomor_gigi = $request->input('nomor_gigi');
        $odontogram->kondisi_gigi = $request->input('kondisi_gigi');
        $odontogram->occlusi = $request->input('occlusi');
        $odontogram->torus_palatinus = $request->input('torus_palatinus');
        $odontogram->torus_mandibularis = $request->input('torus_mandibularis');
        $odontogram->palatum = $request->input('palatum');
        $odontogram->diastema = $request->input('diastema');
        $odontogram->gigi_anomali = $request->input('gigi_anomali');
        $odontogram->lain_lain = $request->input('lain_lain');
        $odontogram->jumlah_foto_rontgen = $request->input('jumlah_foto_rontgen');
        $odontogram->save();

        return redirect()->route('dokter.odontograms.index')->with('success', 'Odontogram berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyOdontogram(Odontogram $odontogram)
    {
        if ($odontogram->dokter_id != Auth::id()) {
            abort(403); // Hanya dokter yang membuat yang bisa menghapus
        }
        $odontogram->delete();
        return redirect()->route('dokter.odontograms.index')->with('success', 'Odontogram berhasil dihapus.');
    }
}

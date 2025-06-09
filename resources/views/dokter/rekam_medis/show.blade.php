@extends('layouts.dokter')

@section('title', 'Rekam Medis Pasien: ' . ($pasien->nama ?? 'Tidak Ditemukan'))

@section('content')
<div class="container mt-4">

    <h1 class="mb-4 text-primary">Rekam Medis Pasien: {{ $pasien->nama ?? 'Tidak Ditemukan' }}</h1>

    <div class="card shadow-sm mb-4 rounded-lg"> {{-- Card dengan bayangan, margin bawah, dan sudut membulat --}}
        <div class="card-header bg-primary text-white py-3"> {{-- Header card dengan background primary, teks putih, padding vertikal --}}
            <h5 class="mb-0"><i class="fas fa-user me-2"></i> Informasi Pasien</h5> {{-- Icon dan judul di header --}}
        </div>
        <div class="card-body"> {{-- Body card --}}
            {{-- Gunakan grid untuk tata letak 2 kolom pada info pasien --}}
            <div class="row">
                <div class="col-md-6">
                    <p class="mb-2"><strong>Nama:</strong> {{ $pasien->nama ?? '-' }}</p>
                    <p class="mb-2"><strong>Tempat/Tanggal Lahir:</strong> {{ $pasien->tempat_lahir ?? '-' }}/{{ $pasien->tanggal_lahir ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d-m-Y') : '-' }}</p>
                    <p class="mb-2"><strong>Jenis Kelamin:</strong> {{ $pasien->jenis_kelamin ?? '-' }}</p>
                </div>
                <div class="col-md-6">
                    <p class="mb-2"><strong>Alamat:</strong> {{ $pasien->alamat ?? '-' }}</p>
                    <p class="mb-2"><strong>No. HP:</strong> {{ $pasien->no_hp ?? '-' }}</p>
                    {{-- Tambahkan detail pasien lain jika perlu --}}
                </div>
            </div>
        </div>
    </div>

    {{-- Kartu Riwayat Catatan Medis --}}
    <div class="card shadow-sm mb-4 rounded-lg">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0"><i class="fas fa-notes-medical me-2"></i> Riwayat Catatan Medis</h5> {{-- Icon dan judul --}}
        </div>
        <div class="card-body">
            @if ($catatanMedis->count() > 0)
                {{-- Gunakan table-responsive agar tabel bisa discroll horizontal di layar kecil --}}
                <div class="table-responsive">
                    {{-- Kelas table-bordered, table-striped (garis selang-seling), table-hover --}}
                    <table class="table table-bordered table-striped table-hover mb-0"> {{-- mb-0 agar tidak ada margin ekstra di bawah tabel --}}
                        <thead>
                            <tr>
                                <th>Tanggal Pemeriksaan</th>
                                <th>Keluhan Utama</th>
                                <th>Diagnosa</th>
                                <th>Tindakan</th>
                                <th>Resep</th>
                                {{-- Tambahkan kolom Catatan Medis lain --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($catatanMedis as $cm)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($cm->tanggal_pemeriksaan)->format('d-m-Y') }}</td>
                                <td>{{ $cm->keluhan_utama ?? '-' }}</td> {{-- Tambah ?? '-' untuk jaga-jaga jika data kosong --}}
                                <td>{{ $cm->diagnosa ?? '-' }}</td>
                                <td>{{ $cm->tindakan ?? '-' }}</td>
                                <td>{{ $cm->resep ?? '-' }}</td>
                                {{-- Tampilkan kolom lain --}}
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                {{-- Gunakan komponen alert Bootstrap untuk pesan jika data kosong --}}
                <div class="alert alert-info mb-0" role="alert">
                    <i class="fas fa-info-circle me-2"></i> Belum ada Catatan Medis untuk pasien ini.
                </div>
            @endif
        </div>
    </div>

    {{-- Kartu Riwayat Odontogram --}}
    <div class="card shadow-sm mb-4 rounded-lg">
        <div class="card-header bg-primary text-white py-3">
            <h5 class="mb-0"><i class="fas fa-tooth me-2"></i> Riwayat Odontogram</h5> {{-- Icon dan judul --}}
        </div>
        <div class="card-body">
            @if ($odontograms->count() > 0)
                {{-- Gunakan table-responsive agar tabel bisa discroll horizontal di layar kecil --}}
                <div class="table-responsive">
                    {{-- Kelas table-bordered, table-striped (garis selang-seling), table-hover --}}
                    <table class="table table-bordered table-striped table-hover mb-0"> {{-- mb-0 agar tidak ada margin ekstra di bawah tabel --}}
                        <thead>
                            <tr>
                                <th>Tanggal</th>
                                <th>No. Gigi</th>
                                <th>Kondisi Gigi</th>
                                <th>Occlusi</th>
                                <th>Torus Palatinus</th>
                                <th>Torus Mandibularis</th>
                                <th>Palatum</th>
                                <th>Diastema</th>
                                <th>Gigi Anomali</th>
                                <th>Lain-lain</th>
                                <th>Rontgen</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($odontograms as $odonto)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($odonto->tanggal_pemeriksaan)->format('d-m-Y') }}</td>
                                <td>{{ $odonto->nomor_gigi ?? '-' }}</td>
                                <td>{{ $odonto->kondisi_gigi ?? '-' }}</td>
                                <td>{{ $odonto->occlusi ?? '-' }}</td>
                                <td>{{ $odonto->torus_palatinus ?? '-' }}</td>
                                <td>{{ $odonto->torus_mandibularis ?? '-' }}</td>
                                <td>{{ $odonto->palatum ?? '-' }}</td>
                                <td>{{ $odonto->diastema ?? '-' }}</td>
                                <td>{{ $odonto->gigi_anomali ?? '-' }}</td>
                                <td>{{ $odonto->lain_lain ?? '-' }}</td>
                                <td>{{ $odonto->jumlah_foto_rontgen ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                {{-- Gunakan komponen alert Bootstrap untuk pesan jika data kosong --}}
                <div class="alert alert-info mb-0" role="alert">
                    <i class="fas fa-info-circle me-2"></i> Belum ada data Odontogram untuk pasien ini.
                </div>
            @endif
        </div>
    </div>

    {{-- Tombol Aksi --}}
    <div class="mt-4 mb-4"> {{-- Margin top dan bottom untuk tombol --}}
        <a href="{{ route('dokter.rekam_medis.index') }}" class="btn btn-secondary me-2"> {{-- Tombol kembali dengan icon dan margin kanan --}}
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Pencarian
        </a>
        {{-- Tombol cetak PDF dengan icon, membuka di tab baru --}}
        <a href="{{ route('dokter.rekam_medis.cetak_pdf', $pasien->id) }}" class="btn btn-primary" target="_blank">
            <i class="fas fa-print me-1"></i> Cetak Rekam Medis PDF
        </a>
    </div>


</div>
@endsection

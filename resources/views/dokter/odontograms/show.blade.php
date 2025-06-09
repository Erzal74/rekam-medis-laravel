@extends('layouts.dokter')

@section('title', 'Detail Odontogram')
@section('header', 'Detail Odontogram')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm rounded-lg">
            <div class="card-header bg-info text-white py-3">
                <h5 class="mb-0"><i class="fas fa-fw fa-tooth me-2"></i> Detail Odontogram</h5>
            </div>
            <div class="card-body">
                <h6 class="card-subtitle mb-3 text-muted">Informasi Pemeriksaan Gigi</h6>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1"><strong><i class="fas fa-calendar-alt me-2"></i> Tanggal Pemeriksaan:</strong> {{ \Carbon\Carbon::parse($odontogram->tanggal_pemeriksaan)->isoFormat('D MMMM Y') }}</p>
                        <p class="mb-1"><strong><i class="fas fa-user-injured me-2"></i> Pasien:</strong> {{ $odontogram->pasien->nama ?? 'Tidak Ada' }}</p>
                        <p class="mb-1"><strong><i class="fas fa-hashtag me-2"></i> Nomor Gigi:</strong> {{ $odontogram->nomor_gigi ?? '-' }}</p>
                        <p class="mb-1"><strong><i class="fas fa-stethoscope me-2"></i> Kondisi Gigi:</strong> {{ $odontogram->kondisi_gigi ?? '-' }}</p>
                        <p class="mb-1"><strong><i class="fas fa-compress-alt me-2"></i> Oklusi:</strong> {{ $odontogram->occlusi ?? '-' }}</p>
                        <p class="mb-1"><strong><i class="fas fa-bone me-2"></i> Torus Palatinus:</strong> {{ $odontogram->torus_palatinus ?? '-' }}</p>
                    </div>
                    <div class="col-md-6">
                        <p class="mb-1"><strong><i class="fas fa-bone me-2"></i> Torus Mandibularis:</strong> {{ $odontogram->torus_mandibularis ?? '-' }}</p>
                        <p class="mb-1"><strong><i class="fas fa-cubes me-2"></i> Palatum:</strong> {{ $odontogram->palatum ?? '-' }}</p>
                        <p class="mb-1"><strong><i class="fas fa-arrows-alt-h me-2"></i> Diastema:</strong> {{ $odontogram->diastema ?? '-' }}</p>
                        <p class="mb-1"><strong><i class="fas fa-exclamation-triangle me-2"></i> Gigi Anomali:</strong> {{ $odontogram->gigi_anomali ?? '-' }}</p>
                        <p class="mb-1"><strong><i class="fas fa-file-alt me-2"></i> Lain - lain:</strong> {{ $odontogram->lain_lain ?? '-' }}</p>
                        <p class="mb-1"><strong><i class="fas fa-x-ray me-2"></i> Jumlah Foto Rontgen:</strong> {{ $odontogram->jumlah_foto_rontgen ?? '-' }}</p>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-start gap-2">
                    <a href="{{ route('dokter.odontograms.edit', $odontogram->id) }}" class="btn btn-warning"><i class="fas fa-edit me-2"></i> Edit</a>
                    <a href="{{ route('dokter.odontograms.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left me-2"></i> Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection

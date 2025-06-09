@extends('layouts.dokter')

@section('title', 'Tambah Odontogram')
@section('header', 'Tambah Odontogram')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('dokter.odontograms.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="tanggal_pemeriksaan" class="form-label">Tanggal Pemeriksaan</label>
                        <input type="date" name="tanggal_pemeriksaan" id="tanggal_pemeriksaan" class="form-control @error('tanggal_pemeriksaan') is-invalid @enderror" required>
                        @error('tanggal_pemeriksaan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="pasien_id" class="form-label">Pasien</label>
                        <select name="pasien_id" id="pasien_id" class="form-control @error('pasien_id') is-invalid @enderror" required>
                            <option value="">Pilih Pasien</option>
                            @if(isset($pasiens))
                                @foreach($pasiens as $pasien)
                                    <option value="{{ $pasien->id }}">{{ $pasien->nama }}</option>
                                @endforeach
                            @else
                                <option value="" disabled>Tidak ada data pasien</option>
                            @endif
                        </select>
                        @error('pasien_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nomor_gigi" class="form-label">Nomor Gigi</label>
                        <input type="text" name="nomor_gigi" id="nomor_gigi" class="form-control @error('nomor_gigi') is-invalid @enderror" required>
                        @error('nomor_gigi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="kondisi_gigi" class="form-label">Kondisi Gigi</label>
                        <input type="text" name="kondisi_gigi" id="kondisi_gigi" class="form-control @error('kondisi_gigi') is-invalid @enderror" required>
                        @error('kondisi_gigi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="occlusi" class="form-label">Occlusi</label>
                        <input type="text" name="occlusi" id="occlusi" class="form-control @error('occlusi') is-invalid @enderror">
                        @error('occlusi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="torus_palatinus" class="form-label">Torus Palatinus</label>
                        <input type="text" name="torus_palatinus" id="torus_palatinus" class="form-control @error('torus_palatinus') is-invalid @enderror">
                        @error('torus_palatinus')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="torus_mandibularis" class="form-label">Torus Mandibularis</label>
                        <input type="text" name="torus_mandibularis" id="torus_mandibularis" class="form-control @error('torus_mandibularis') is-invalid @enderror">
                        @error('torus_mandibularis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="palatum" class="form-label">Palatum</label>
                        <input type="text" name="palatum" id="palatum" class="form-control @error('palatum') is-invalid @enderror">
                        @error('palatum')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="diastema" class="form-label">Diastema</label>
                        <input type="text" name="diastema" id="diastema" class="form-control @error('diastema') is-invalid @enderror">
                        @error('diastema')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="gigi_anomali" class="form-label">Gigi Anomali</label>
                        <input type="text" name="gigi_anomali" id="gigi_anomali" class="form-control @error('gigi_anomali') is-invalid @enderror">
                        @error('gigi_anomali')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="lain_lain" class="form-label">Lain - lain</label>
                        <input type="text" name="lain_lain" id="lain_lain" class="form-control @error('lain_lain') is-invalid @enderror">
                        @error('lain_lain')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jumlah_foto_rontgen" class="form-label">Jumlah Foto Rontgen</label>
                        <input type="text" name="jumlah_foto_rontgen" id="jumlah_foto_rontgen" class="form-control @error('jumlah_foto_rontgen') is-invalid @enderror">
                        @error('jumlah_foto_rontgen')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('dokter.odontograms.index') }}" class="btn btn-secondary ms-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
@endsection

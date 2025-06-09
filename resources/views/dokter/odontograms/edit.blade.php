@extends('layouts.dokter')

@section('title', 'Edit Odontogram')
@section('header', 'Edit Odontogram')

@section('content')
    <div class="container">
        <form action="{{ route('dokter.odontograms.update', $odontogram->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="tanggal_pemeriksaan">Tanggal Pemeriksaan</label>
                <input type="date" name="tanggal_pemeriksaan" id="tanggal_pemeriksaan"
                    value="{{ $odontogram->tanggal_pemeriksaan }}"
                    class="form-control @error('tanggal_pemeriksaan') is-invalid @enderror" required>
                @error('tanggal_pemeriksaan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="pasien_id">Pasien</label>
                <select name="pasien_id" id="pasien_id" class="form-control @error('pasien_id') is-invalid @enderror">
                    <option value="">Pilih Pasien</option>
                    @foreach ($pasiens as $pasien)
                        <option value="{{ $pasien->id }}" {{ $odontogram->pasien_id == $pasien->id ? 'selected' : '' }}>
                            {{ $pasien->nama }}</option>
                    @endforeach
                </select>
                @error('pasien_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="nomor_gigi">Nomor Gigi</label>
                <input type="text" name="nomor_gigi" id="nomor_gigi" value="{{ $odontogram->nomor_gigi }}"
                    class="form-control @error('nomor_gigi') is-invalid @enderror" required>
                @error('nomor_gigi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="kondisi_gigi">Kondisi Gigi</label>
                <input type="text" name="kondisi_gigi" id="kondisi_gigi" value="{{ $odontogram->kondisi_gigi }}"
                    class="form-control @error('kondisi_gigi') is-invalid @enderror" required>
                @error('kondisi_gigi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="occlusi">Occlusi</label>
                <input type="text" name="occlusi" id="occlusi" value="{{ $odontogram->occlusi }}"
                    class="form-control @error('occlusi') is-invalid @enderror">
                @error('occlusi')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="torus_palatinus">Torus Palatinus</label>
                <input type="text" name="torus_palatinus" id="torus_palatinus"
                    value="{{ $odontogram->torus_palatinus }}"
                    class="form-control @error('torus_palatinus') is-invalid @enderror">
                @error('torus_palatinus')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="torus_mandibularis">Torus Mandibularis</label>
                <input type="text" name="torus_mandibularis" id="torus_mandibularis"
                    value="{{ $odontogram->torus_mandibularis }}"
                    class="form-control @error('torus_mandibularis') is-invalid @enderror">
                @error('torus_mandibularis')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="palatum">Palatum</label>
                <input type="text" name="palatum" id="palatum" value="{{ $odontogram->palatum }}"
                    class="form-control @error('palatum') is-invalid @enderror">
                @error('palatum')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="diastema">Diastema</label>
                <input type="text" name="diastema" id="diastema" value="{{ $odontogram->diastema }}"
                    class="form-control @error('diastema') is-invalid @enderror">
                @error('diastema')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="gigi_anomali">Gigi Anomali</label>
                <input type="text" name="gigi_anomali" id="gigi_anomali" value="{{ $odontogram->gigi_anomali }}"
                    class="form-control @error('gigi_anomali') is-invalid @enderror">
                @error('gigi_anomali')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="lain_lain">Lain - lain</label>
                <input type="text" name="lain_lain" id="lain_lain" value="{{ $odontogram->lain_lain }}"
                    class="form-control @error('lain_lain') is-invalid @enderror">
                @error('lain_lain')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="jumlah_foto_rontgen">Jumlah Foto Rontgen:</label>
                <input type="number" name="jumlah_foto_rontgen" id="jumlah_foto_rontgen" class="form-control"
                    value="{{ old('jumlah_foto_rontgen', $odontogram->jumlah_foto_rontgen ?? '') }}">
                @error('jumlah_foto_rontgen')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Simpan</button>
            <a href="{{ route('dokter.odontograms.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
@endsection

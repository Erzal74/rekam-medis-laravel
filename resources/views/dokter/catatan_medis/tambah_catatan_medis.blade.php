@extends('layouts.dokter')

@section('header')
    Tambah Catatan Medis Baru
@endsection

@section('content')
    <div class="content">
        <h3>Informasi Pasien</h3>
        <div class="mb-3">
            <label for="nama_pasien" class="form-label">Nama Pasien:</label>
            <input type="text" class="form-control" id="nama_pasien" value="{{ $pasien->nama ?? '' }}" readonly>
        </div>
        <div class="mb-3">
            <label for="id_pasien" class="form-label">ID Pasien:</label>
            <input type="text" class="form-control" id="id_pasien" value="{{ $pasien->id ?? '' }}" readonly>
        </div>

        <hr class="my-4">

        <h3>Formulir Catatan Medis</h3>
        <form action="{{ route('dokter.catatan_medis.store') }}" method="POST">
            @csrf
            <input type="hidden" name="pasien_id" value="{{ $pasien->id ?? '' }}">

            <div class="mb-3">
                <label for="tanggal_pemeriksaan" class="form-label">Tanggal Pemeriksaan:</label>
                <input type="date" class="form-control" id="tanggal_pemeriksaan" name="tanggal_pemeriksaan" required>
            </div>

            <div class="mb-3">
                <label for="keluhan_utama" class="form-label">Keluhan Utama:</label>
                <textarea class="form-control" id="keluhan_utama" name="keluhan_utama" rows="3" required></textarea>
            </div>

            <div class="mb-3">
                <label for="diagnosa" class="form-label">Diagnosa:</label>
                <textarea class="form-control" id="diagnosa" name="diagnosa" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label for="tindakan" class="form-label">Tindakan:</label>
                <textarea class="form-control" id="tindakan" name="tindakan" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label for="resep" class="form-label">Resep Obat:</label>
                <textarea class="form-control" id="resep" name="resep" rows="3"></textarea>
            </div>

            <div class="mb-3">
                <label for="catatan_tambahan" class="form-label">Catatan Tambahan:</label>
                <textarea class="form-control" id="catatan_tambahan" name="catatan_tambahan" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Catatan Medis</button>
            <a href="{{ route('dokter.catatan_medis.index', ['pasien_id' => $pasien->id ?? '']) }}" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
@endsection

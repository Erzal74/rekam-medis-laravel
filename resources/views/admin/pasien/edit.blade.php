{{-- resources/views/admin/pasien/edit.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Data Pasien')
@section('header', 'Edit Data Pasien')

@section('content')
    <div class="container mt-4">
        {{-- Tambahkan ini untuk menampilkan error validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.pasien.update', $pasien->id) }}" method="POST" enctype="multipart/form-data" class="card p-4 rounded-4 shadow-sm">
            @csrf
            @method('PUT')
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="nama" class="form-label">Nama Pasien</label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $pasien->nama) }}" required>
                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                {{-- NIK field removed --}}
                <div class="col-md-6">
                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="form-control @error('tempat_lahir') is-invalid @enderror" value="{{ old('tempat_lahir', $pasien->tempat_lahir) }}">
                    @error('tempat_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div><div class="col-md-6">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir', $pasien->tanggal_lahir) }}">
                    @error('tanggal_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="tanggal_berkunjung" class="form-label">Tanggal Berkunjung</label>
                    <input type="date" name="tanggal_berkunjung" class="form-control @error('tanggal_berkunjung') is-invalid @enderror" value="{{ old('tanggal_berkunjung', $pasien->tanggal_berkunjung) }}">
                    @error('tanggal_berkunjung') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-12">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" rows="2" class="form-control @error('alamat') is-invalid @enderror" required>{{ old('alamat', $pasien->alamat) }}</textarea>
                    @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="no_hp" class="form-label">No. Telepon</label> {{-- Label for diubah --}}
                    <input type="text" name="no_hp" class="form-control @error('no_hp') is-invalid @enderror" value="{{ old('no_hp', $pasien->no_hp) }}" required> {{-- Name dan value/old() diubah --}}
                    @error('no_hp') <div class="invalid-feedback">{{ $message }}</div> @enderror {{-- Error key diubah --}}
                </div>
                <div class="col-md-6">
                    <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                    <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror">
                        <option value="">Pilih...</option>
                        <option value="Laki-laki" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ old('jenis_kelamin', $pasien->jenis_kelamin) == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="status" class="form-label">Status</label>
                    <input type="text" name="status" class="form-control @error('status') is-invalid @enderror" value="{{ old('status', $pasien->status) }}">
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                {{-- Hapus bagian No. KK --}}
                {{-- <div class="col-md-6">
                    <label for="no_kk" class="form-label">No. KK</label>
                    <input type="text" name="no_kk" class="form-control @error('no_kk') is-invalid @enderror" value="{{ old('no_kk', $pasien->no_kk) }}">
                    @error('no_kk') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div> --}}
                {{-- Hapus bagian Upload Foto KTP dan tampilan foto --}}
                {{-- <div class="col-md-6">
                    <label for="foto_ktp" class="form-label">Upload Foto KTP</label>
                    <input type="file" name="foto_ktp" class="form-control @error('foto_ktp') is-invalid @enderror" accept="image/*">
                    @error('foto_ktp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    @if($pasien->foto_ktp)
                        <img src="{{ asset('storage/foto_ktp/' . $pasien->foto_ktp) }}" alt="KTP" width="80" class="mt-2 rounded">
                    @endif
                </div>
                <div class="col-md-6">
                    {{-- Placeholder or can be left empty --}}
                </div>
            </div>
            <div class="mt-4">
                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="{{ route('admin.pasien.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection

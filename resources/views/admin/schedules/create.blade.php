{{-- resources/views/admin/schedules/create.blade.php --}}
@extends('layouts.admin') {{-- Pastikan ini mengarah ke layout admin Anda --}}

@section('title', 'Tambah Jadwal Dokter')
@section('header', 'Tambah Jadwal Dokter')

@section('content')
    <div class="container mt-4">
        {{-- Menampilkan error validasi --}}
        @if ($errors->any())
            <div class="alert alert-danger mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Tambah Jadwal --}}
        <form action="{{ route('admin.schedules.store') }}" method="POST" class="card p-4 rounded-4 shadow-sm">
            @csrf {{-- Token keamanan --}}
            <div class="row g-3">
                {{-- Field Nama Dokter (Dropdown) --}}
                <div class="col-md-6">
                    <label for="doctor_id" class="form-label">Nama Dokter</label>
                    {{-- Select dropdown untuk memilih dokter --}}
                    <select name="doctor_id" id="doctor_id" class="form-select @error('doctor_id') is-invalid @enderror" required>
                        <option value="">Pilih Dokter...</option>
                        {{-- Loop untuk menampilkan daftar dokter dari controller --}}
                        @foreach ($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                {{ $doctor->name }} {{-- Asumsi kolom nama di model Doctor adalah 'name' --}}
                            </option>
                        @endforeach
                    </select>
                    {{-- Menampilkan pesan error validasi untuk doctor_id --}}
                    @error('doctor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Field Tanggal --}}
                <div class="col-md-6">
                    <label for="date" class="form-label">Tanggal</label>
                    <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date') }}" required>
                    {{-- Menampilkan pesan error validasi untuk date --}}
                    @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Field Jenis Acara --}}
                <div class="col-md-6">
                    <label for="type" class="form-label">Jenis Acara</label>
                    {{-- Select dropdown untuk jenis acara --}}
                     <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                        <option value="">Pilih Jenis...</option>
                        {{-- Opsi jenis acara --}}
                        <option value="Cuti" {{ old('type') == 'Cuti' ? 'selected' : '' }}>Cuti</option>
                        <option value="Rapat" {{ old('type') == 'Rapat' ? 'selected' : '' }}>Rapat</option>
                        <option value="Training" {{ old('type') == 'Training' ? 'selected' : '' }}>Training</option>
                        <option value="Lainnya" {{ old('type') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    {{-- Menampilkan pesan error validasi untuk type --}}
                    @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                {{-- Spacer column untuk layout --}}
                 <div class="col-md-6"></div>

                {{-- Field Keterangan (Optional) --}}
                <div class="col-12">
                    <label for="description" class="form-label">Keterangan (Opsional)</label>
                    <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                    {{-- Menampilkan pesan error validasi untuk description --}}
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- Tombol Simpan dan Batal --}}
            <div class="mt-4">
                <button type="submit" class="btn btn-success">Simpan</button>
                <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection

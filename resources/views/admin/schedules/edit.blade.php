{{-- resources/views/admin/schedules/edit.blade.php --}}
@extends('layouts.admin') {{-- Pastikan ini mengarah ke layout admin Anda --}}

@section('title', 'Edit Jadwal Dokter')
@section('header', 'Edit Jadwal Dokter')

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

        {{-- Form Edit Jadwal --}}
        {{-- Action mengarah ke route update, method PUT --}}
        <form action="{{ route('admin.schedules.update', $schedule->id) }}" method="POST" class="card p-4 rounded-4 shadow-sm">
            @csrf {{-- Token keamanan --}}
            @method('PUT') {{-- Mengubah method POST menjadi PUT --}}
            <div class="row g-3">
                {{-- Field Nama Dokter (Dropdown) --}}
                <div class="col-md-6">
                    <label for="doctor_id" class="form-label">Nama Dokter</label>
                    <select name="doctor_id" id="doctor_id" class="form-select @error('doctor_id') is-invalid @enderror" required>
                        <option value="">Pilih Dokter...</option>
                        {{-- Loop daftar dokter, opsi terpilih sesuai data jadwal atau old input --}}
                        @foreach ($doctors as $doctor)
                            <option value="{{ $doctor->id }}" {{ old('doctor_id', $schedule->doctor_id) == $doctor->id ? 'selected' : '' }}>
                                {{ $doctor->name }} {{-- Asumsi kolom nama di model Doctor adalah 'name' --}}
                            </option>
                        @endforeach
                    </select>
                    {{-- Menampilkan pesan error validasi --}}
                    @error('doctor_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Field Tanggal --}}
                <div class="col-md-6">
                    <label for="date" class="form-label">Tanggal</label>
                     {{-- Value diisi dari data jadwal lama atau old input, diformat Y-m-d untuk input date --}}
                    <input type="date" name="date" id="date" class="form-control @error('date') is-invalid @enderror" value="{{ old('date', $schedule->date ? $schedule->date->format('Y-m-d') : '') }}" required>
                    {{-- Menampilkan pesan error validasi --}}
                    @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                {{-- Field Jenis Acara --}}
                <div class="col-md-6">
                    <label for="type" class="form-label">Jenis Acara</label>
                    <select name="type" id="type" class="form-select @error('type') is-invalid @enderror" required>
                        <option value="">Pilih Jenis...</option>
                         {{-- Opsi jenis acara, terpilih sesuai data jadwal atau old input --}}
                        <option value="Cuti" {{ old('type', $schedule->type) == 'Cuti' ? 'selected' : '' }}>Cuti</option>
                        <option value="Rapat" {{ old('type', $schedule->type) == 'Rapat' ? 'selected' : '' }}>Rapat</option>
                        <option value="Training" {{ old('type', $schedule->type) == 'Training' ? 'selected' : '' }}>Training</option>
                        <option value="Lainnya" {{ old('type', $schedule->type) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    {{-- Menampilkan pesan error validasi --}}
                    @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                 {{-- Spacer column --}}
                 <div class="col-md-6"></div>


                {{-- Field Keterangan (Optional) --}}
                <div class="col-12">
                    <label for="description" class="form-label">Keterangan (Opsional)</label>
                    {{-- Textarea diisi dari data jadwal lama atau old input --}}
                    <textarea name="description" id="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $schedule->description) }}</textarea>
                    {{-- Menampilkan pesan error validasi --}}
                    @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            {{-- Tombol Simpan Perubahan dan Batal --}}
            <div class="mt-4">
                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                <a href="{{ route('admin.schedules.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
@endsection

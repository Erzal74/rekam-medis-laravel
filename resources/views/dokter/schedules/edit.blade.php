@extends('layouts.dokter')

@section('title', 'Edit Jadwal')
@section('header')
    Edit Jadwal
@endsection

@section('content')
    <div class="bg-white shadow rounded p-4">
        <h5 class="card-title mb-3 text-gray-600"><i class="fas fa-edit mr-2"></i> Edit Jadwal</h5>
        <form action="{{ route('dokter.schedules.update', $schedule->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="date" class="form-label">Tanggal</label>
                <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date', $schedule->date ? \Carbon\Carbon::parse($schedule->date)->format('Y-m-d') : '') }}" required>
                @error('date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="type" class="form-label">Jenis Acara</label>
                <input type="text" class="form-control @error('type') is-invalid @enderror" id="type" name="type" value="{{ old('type', $schedule->type) }}" required>
                @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Keterangan</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $schedule->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-2"></i> Update</button>
                <a href="{{ route('dokter.schedules.index') }}" class="btn btn-secondary"><i class="fas fa-times mr-2"></i> Batal</a>
            </div>
        </form>
    </div>
@endsection

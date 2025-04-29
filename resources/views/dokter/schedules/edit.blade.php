@extends('layouts.dokter')

@section('title', 'Edit Jadwal')
@section('header')
    <h1>Edit Jadwal</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
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
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('dokter.schedules.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
@endsection

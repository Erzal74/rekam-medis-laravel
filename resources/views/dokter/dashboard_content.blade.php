@extends('layouts.dokter')

@section('title', 'Dashboard Dokter')
@section('header')
    <h1>Dashboard Dokter</h1>
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Profil Dokter</h5>
                    <p class="card-text"><i class="fas fa-user-md me-2"></i> Dr. Erlyn Aprilia {{ $dokter->nama }}</p>
                    @if(isset($dokter->spesialisasi))
                        <p class="card-text"><i class="fas fa-briefcase me-2"></i> Spesialis Gigi {{ $dokter->spesialisasi }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-users me-2"></i> Jumlah Pasien Hari Ini</h5>
                    <p class="card-text display-4">{{ $jumlahPasienHariIni }}</p>
                    <div class="d-flex justify-content-between">
                        <p class="card-text"><i class="fas fa-user me-2"></i> Pasien Lama: <span class="fw-bold">{{ $jumlahPasienLamaHariIni }}</span></p>
                        <p class="card-text"><i class="fas fa-user-plus me-2"></i> Pasien Baru: <span class="fw-bold">{{ $jumlahPasienBaruHariIni }}</span></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-calendar-alt me-2"></i> Jadwal Kunjungan Hari Ini</h5>
                    @if ($jadwalKunjunganHariIni->count() > 0)
                        <ul class="list-group list-group-flush">
                            @foreach ($jadwalKunjunganHariIni as $jadwal)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span><i class="far fa-clock me-2"></i> {{ \Carbon\Carbon::parse($jadwal->waktu_kunjungan)->format('H:i') }}</span>
                                    <span class="fw-bold">{{ $jadwal->pasien->nama }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="card-text">Tidak ada jadwal kunjungan hari ini.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><i class="fas fa-clipboard-list me-2"></i> To-Do List</h5>
                    <form action="{{ route('dokter.todo.store') }}" method="POST" class="mb-3">
                        @csrf
                        <div class="input-group">
                            <input type="text" name="deskripsi" class="form-control" placeholder="Tambahkan catatan baru...">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-plus"></i> Tambah</button>
                        </div>
                        @error('deskripsi')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </form>
                    <ul class="list-group list-group-flush">
                        @forelse ($todoList as $todo)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span><i class="far fa-sticky-note me-2"></i> {{ $todo->deskripsi }}</span>
                                <div class="todo-actions">
                                    <a href="{{ route('dokter.todo.edit', $todo->id) }}" class="btn btn-sm btn-warning me-2"><i class="fas fa-edit"></i> Edit</a>
                                    <form action="{{ route('dokter.todo.destroy', $todo->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus catatan ini?')"><i class="fas fa-trash-alt"></i> Hapus</button>
                                    </form>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item">Tidak ada catatan.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.dokter')

@section('title', 'Dashboard Dokter')

@section('header')
    Dashboard
@endsection

@section('content')
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="bg-white shadow rounded p-4">
                <div class="d-flex align-items-center">
                    <i class="fas fa-users fa-3x text-primary mr-3"></i>
                    <div>
                        <h6 class="mb-1 text-gray-600">Jumlah Pasien Hari Ini</h6>
                        <h3 class="font-semibold text-xl text-primary">{{ $jumlahPasienHariIni }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="bg-white shadow rounded p-4">
                <h6 class="mb-3 text-gray-600"><i class="fas fa-calendar-alt mr-2"></i> Jadwal Kunjungan Hari Ini</h6>
                @if ($jadwalKunjunganHariIni->count() > 0)
                    <ul class="list-none p-0">
                        @foreach ($jadwalKunjunganHariIni as $jadwal)
                            <li class="py-2 border-b last:border-b-0 flex justify-between items-center">
                                <div>
                                    <i class="far fa-clock text-info mr-2"></i>
                                    <span>{{ \Carbon\Carbon::parse($jadwal->waktu_kunjungan)->format('H:i') }}</span>
                                </div>
                                <span class="font-semibold text-success">{{ $jadwal->pasien->nama }}</span>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500">Tidak ada jadwal kunjungan hari ini.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="bg-white shadow rounded p-4">
        <h6 class="mb-3 text-gray-600"><i class="fas fa-clipboard-list mr-2"></i> To-Do List</h6>
        <form action="{{ route('dokter.todo.store') }}" method="POST" class="mb-3">
            @csrf
            <div class="flex">
                <input type="text" name="deskripsi" class="form-control flex-grow mr-2" placeholder="Tambahkan catatan baru...">
                <button type="submit" class="btn btn-info"><i class="fas fa-plus mr-1"></i> Tambah</button>
            </div>
            @error('deskripsi')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </form>
        <ul class="list-none p-0">
            @forelse ($todoList as $todo)
                <li class="py-2 border-b last:border-b-0 flex justify-between items-center">
                    <div>
                        <i class="far fa-sticky-note text-warning mr-2"></i>
                        <span>{{ $todo->deskripsi }}</span>
                    </div>
                    <div class="flex gap-2">
                        <a href="{{ route('dokter.todo.edit', $todo->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('dokter.todo.destroy', $todo->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus catatan ini?')"><i class="fas fa-trash-alt"></i> Hapus</button>
                        </form>
                    </div>
                </li>
            @empty
                <li class="text-gray-500">Tidak ada catatan.</li>
            @endforelse
        </ul>
    </div>
@endsection

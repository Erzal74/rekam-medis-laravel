@extends('layouts.dokter')

@section('title', 'Jadwal Saya')
@section('header')
    Jadwal Saya
@endsection

@section('content')
    <div class="mb-4">
        <a href="{{ route('dokter.schedules.create') }}" class="btn btn-primary"><i class="fas fa-plus mr-2"></i> Tambah Jadwal</a>
    </div>

    <div class="bg-white shadow rounded p-4">
        <h5 class="card-title mb-3 text-gray-600"><i class="fas fa-calendar-alt mr-2"></i> Daftar Jadwal Saya</h5>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jenis Acara</th>
                        <th>Keterangan</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($schedules as $schedule)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ \Carbon\Carbon::parse($schedule->date)->format('d-m-Y') }}</td>
                            <td>{{ $schedule->type }}</td>
                            <td>{{ $schedule->description }}</td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('dokter.schedules.edit', $schedule->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                    <form action="{{ route('dokter.schedules.destroy', $schedule->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')"><i class="fas fa-trash-alt"></i> Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-gray-500">Belum ada data jadwal.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

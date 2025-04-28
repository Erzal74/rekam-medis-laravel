{{-- resources/views/admin/schedules/index.blade.php --}}
@extends('layouts.admin') {{-- Pastikan ini mengarah ke layout admin Anda --}}

@section('title', 'Jadwal Dokter')
@section('header', 'Jadwal Dokter')

@section('content')
    <div class="container mt-4">
        {{-- Menampilkan pesan sukses/error dari session --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                {{-- {{ session('error') }} --}}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h3 class="mb-4">Daftar Jadwal Dokter</h3>
        {{-- Tombol Tambah Jadwal DIHAPUS --}}
        {{-- <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Jadwal
            </a>
        </div> --}}

        <div class="card shadow-sm rounded-4">
            <div class="card-body table-responsive">
                {{-- Tabel untuk menampilkan data jadwal --}}
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Dokter</th>
                            <th>Tanggal</th>
                            <th>Jenis Acara</th>
                            <th>Keterangan</th>
                            {{-- Kolom Aksi DIHAPUS --}}
                            {{-- <th>Aksi</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Loop data jadwal --}}
                        @forelse ($schedules as $schedule)
                            <td>{{ $loop->iteration + ($schedules->currentPage() - 1) * $schedules->perPage() }}</td>
                            <td>{{ $schedule->doctor->name ?? 'N/A' }}</td>
                            <td>{{ $schedule->date->isoFormat('D MMMM Y') }}</td>
                            <td>{{ $schedule->type }}</td>
                            <td>{{ $schedule->description ?? '-' }}</td>
                            {{-- ... --}}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">Belum ada data jadwal dokter.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{-- Menampilkan link pagination --}}
                <div class="mt-3 d-flex justify-content-center">
                    {{ $schedules->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- resources/views/admin/schedules/index.blade.php --}}
@extends('layouts.admin') {{-- Pastikan ini mengarah ke layout admin Anda --}}

@section('title', 'Jadwal Dokter')
@section('header', 'Jadwal Dokter')

@section('content')
    <div class="container mt-4">
        {{-- Menampilkan pesan sukses/error dari session --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
             <div class="alert alert-danger alert-dismissible fade show" role="alert">
                 {{ session('error') }}
                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
             </div>
         @endif

        <h3 class="mb-4">Daftar Jadwal Dokter</h3>
        <div class="d-flex justify-content-end mb-3">
            {{-- Tombol Tambah Jadwal, mengarah ke route create --}}
            <a href="{{ route('admin.schedules.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Jadwal
            </a>
        </div>

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
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Loop data jadwal, menggunakan @forelse untuk menangani jika data kosong --}}
                        @forelse ($schedules as $index => $schedule)
                            <tr>
                                {{-- Penomoran, disesuaikan jika menggunakan pagination --}}
                                <td>{{ $index + 1 + ($schedules->currentPage() - 1) * $schedules->perPage() }}</td>
                                {{-- Menampilkan nama dokter dari relasi 'doctor' --}}
                                <td>{{ $schedule->doctor->name ?? 'N/A' }}</td> {{-- Asumsi kolom nama di model Doctor adalah 'name' --}}
                                {{-- Menampilkan tanggal dengan format Indonesia --}}
                                <td>{{ $schedule->date->isoFormat('D MMMMYYYY') }}</td>
                                {{-- Menampilkan jenis acara --}}
                                <td>{{ $schedule->type }}</td>
                                {{-- Menampilkan keterangan, jika kosong tampilkan '-' --}}
                                <td>{{ $schedule->description ?? '-' }}</td>
                                <td>
                                    {{-- Tombol Aksi: Edit dan Hapus --}}
                                    <div class="d-flex justify-content-center gap-2">
                                        {{-- Tombol Edit, mengarah ke route edit --}}
                                        <a href="{{ route('admin.schedules.edit', $schedule->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        {{-- Form untuk Hapus, menggunakan method DELETE --}}
                                        <form action="{{ route('admin.schedules.destroy', $schedule->id) }}" method="POST" class="d-inline">
                                            @csrf {{-- Token keamanan --}}
                                            @method('DELETE') {{-- Mengubah method POST menjadi DELETE --}}
                                            {{-- Tombol Hapus dengan konfirmasi JavaScript --}}
                                            <button type="submit" onclick="return confirm('Yakin hapus jadwal dokter {{ $schedule->doctor->name ?? 'ini' }} pada tanggal {{ $schedule->date->isoFormat('D MMMMYYYY') }}?')" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        {{-- Jika tidak ada data jadwal --}}
                        @empty
                            <tr>
                                {{-- colspan harus sesuai dengan jumlah kolom di header tabel --}}
                                <td colspan="6" class="text-center">Belum ada data jadwal dokter.</td>
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

@extends('layouts.dokter')

@section('title', 'Daftar Odontogram')
@section('header', 'Daftar Odontogram')

@section('content')
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="mb-3">
            <a href="{{ route('dokter.odontograms.create') }}" class="btn btn-primary">Tambah Odontogram</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal Pemeriksaan</th>
                        <th>Nama Pasien</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($odontograms as $odontogram)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $odontogram->tanggal_pemeriksaan }}</td>
                            <td>{{ $odontogram->pasien->nama ?? 'Tidak Ada' }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('dokter.odontograms.show', $odontogram->id) }}" class="btn btn-sm btn-info">Detail</a>
                                    <a href="{{ route('dokter.odontograms.edit', $odontogram->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                    <form action="{{ route('dokter.odontograms.destroy', $odontogram->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus odontogram ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada data odontogram.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection

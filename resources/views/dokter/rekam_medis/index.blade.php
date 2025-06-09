{{-- resources/views/dokter/rekam_medis/index.blade.php --}}
@extends('layouts.dokter')

@section('title', 'Cari Rekam Medis')
@section('header', 'Cari Rekam Medis')

@section('content')
    <div class="container mt-4">
        <div class="card shadow-sm rounded-lg">
            <div class="card-header bg-primary text-white py-3">
                <h5 class="mb-0">Cari Rekam Medis Pasien</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('dokter.rekam_medis.show') }}" method="GET">
                    <div class="mb-3">
                        <label for="nama_pasien" class="form-label">Nama Pasien:</label>
                        <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" placeholder="Masukkan nama pasien">
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search me-2"></i> Cari</button>
                </form>
            </div>
        </div>

        @if (session('error'))
            <div class="alert alert-danger mt-3">
                <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
            </div>
        @endif

        @if (isset($results) && $results->isNotEmpty())
            <div class="mt-4">
                <h5 class="mb-3">Hasil Pencarian:</h5>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Pasien</th>
                                <th>Tanggal Lahir</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($results as $pasien)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pasien->nama }}</td>
                                    <td>{{ $pasien->tanggal_lahir ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->isoFormat('D MMMM Y') : '-' }}</td>
                                    <td>{{ $pasien->alamat ?? '-' }}</td>
                                    <td>
                                        <a href="{{ route('dokter.rekam_medis.show', ['nama_pasien' => $pasien->nama]) }}" class="btn btn-sm btn-info"><i class="fas fa-eye me-1"></i> Lihat Rekam Medis</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @elseif (isset($results) && $results->isEmpty())
            <div class="alert alert-warning mt-3">
                <i class="fas fa-info-circle me-2"></i> Tidak ada pasien dengan nama tersebut. Silakan coba lagi.
            </div>
        @endif
    </div>
@endsection

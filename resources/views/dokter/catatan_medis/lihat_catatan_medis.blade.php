@extends('layouts.dokter')

@section('header')
    Catatan Medis Pasien: {{ $pasien->nama ?? 'Tidak Ada' }}
@endsection

@section('content')
    <div class="content">
        <h3>Daftar Catatan Medis</h3>

        <div class="mb-3">
            <a href="{{ route('dokter.catatan_medis.create', ['pasien_id' => $pasien->id ?? '']) }}" class="btn btn-success">
                <i class="fas fa-plus me-2"></i> Tambah Catatan Baru
            </a>
        </div>

        @if ($catatanMedis->isEmpty())
            <p>Belum ada catatan medis untuk pasien ini.</p>
        @else
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tanggal Pemeriksaan</th>
                        <th>Keluhan Utama</th>
                        <th>Diagnosa</th>
                        <th>Tindakan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($catatanMedis as $key => $catatan)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $catatan->tanggal_pemeriksaan }}</td>
                            <td>{{ $catatan->keluhan_utama }}</td>
                            <td>{{ $catatan->diagnosa }}</td>
                            <td>{{ $catatan->tindakan }}</td>
                            <td>
                                <a href="{{ route('dokter.catatan_medis.show', $catatan->id) }}" class="btn btn-sm btn-info"><i class="fas fa-eye"></i> Lihat</a>
                                <a href="{{ route('dokter.catatan_medis.edit', $catatan->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i> Edit</a>
                                <form action="{{ route('dokter.catatan_medis.destroy', $catatan->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus catatan ini?')"><i class="fas fa-trash"></i> Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection

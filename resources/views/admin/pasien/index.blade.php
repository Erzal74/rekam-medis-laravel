{{-- resources/views/admin/pasien/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Data Pasien')
@section('header', 'Data Pasien')

@section('content')
    <div class="container mt-4">
        {{-- Tambahkan ini untuk menampilkan pesan success/error --}}
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

        <h3 class="mb-4">Daftar Pasien</h3>
        <div class="d-flex justify-content-end mb-3">
            <a href="{{ route('admin.pasien.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Pasien
            </a>
        </div>

        <div class="card shadow-sm rounded-4">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-hover align-middle text-center">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            {{-- NIK column header removed --}}
                            <th>Tempat Lahir</th>
                            <th>Tanggal Lahir</th>
                            <th>Tanggal Berkunjung</th>
                            <th>Alamat</th>
                            <th>No. Telepon</th> {{-- Header diubah --}}
                            <th>Jenis Kelamin</th>
                            <th>No. KK</th>
                            <th>Status</th>
                            <th>Foto KTP</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($pasiens as $index => $p)
                            <tr>
                                <td>{{ $index + 1 + ($pasiens->currentPage() - 1) * $pasiens->perPage() }}</td> {{-- Penomoran untuk pagination --}}
                                <td>{{ $p->nama }}</td>
                                {{-- NIK data cell removed --}}
                                <td>{{ $p->tempat_lahir }}</td>
                                <td>{{ $p->tanggal_lahir ? \Carbon\Carbon::parse($p->tanggal_lahir)->isoFormat('D MMMM YYYY') : '-' }}</td> {{-- Format Tanggal --}}
                                <td>{{ $p->tanggal_berkunjung ? \Carbon\Carbon::parse($p->tanggal_berkunjung)->isoFormat('D MMMM YYYY') : '-' }}</td> {{-- Format Tanggal --}}
                                <td>{{ $p->alamat }}</td>
                                <td>{{ $p->no_hp }}</td> {{-- Data diubah --}}
                                <td>{{ $p->jenis_kelamin }}</td>
                                <td>{{ $p->no_kk }}</td>
                                <td>{{ $p->status }}</td>
                                <td>
                                    @if($p->foto_ktp)
                                        <img src="{{ asset('storage/foto_ktp/' . $p->foto_ktp) }}" alt="KTP" width="80" class="rounded img-thumbnail">
                                    @else
                                        <span class="badge bg-secondary">Tidak ada</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('admin.pasien.edit', $p->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.pasien.destroy', $p->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Yakin hapus data pasien {{ $p->nama }}?')" class="btn btn-sm btn-danger" title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                {{-- Colspan updated from 13 to 12 --}}
                                <td colspan="12" class="text-center">Belum ada data pasien.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{-- Tambahkan link pagination --}}
                <div class="mt-3 d-flex justify-content-center">
                    {{ $pasiens->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

{{-- Tambahkan ini di layout admin Anda (misal layouts/admin.blade.php) sebelum </body> jika belum ada --}}
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}} {{-- Jika menggunakan Bootstrap 5 JS --}}

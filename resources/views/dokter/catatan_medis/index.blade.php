@extends('layouts.dokter')

@section('title', 'Daftar Catatan Medis')
@section('header')
    Daftar Catatan Medis
@endsection

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <a href="{{ route('dokter.catatan_medis.create') }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">
                        {{ __('Tambah Catatan Medis') }}
                    </a>

                    @if ($catatanMedis->isEmpty())
                        <p class="text-gray-600">{{ __('Belum ada catatan medis.') }}</p>
                    @else
                        <div class="overflow-x-auto">
                            <table class="min-w-full leading-normal">
                                <thead>
                                    <tr>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('No') }}
                                        </th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Nama Pasien') }}
                                        </th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Tanggal Pemeriksaan') }}
                                        </th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Keluhan Utama') }}
                                        </th>
                                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                            {{ __('Aksi') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($catatanMedis as $catatan)
                                        <tr>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                {{ $loop->iteration }}
                                            </td>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                {{ $catatan->pasien->nama }}
                                            </td>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                {{ \Carbon\Carbon::parse($catatan->tanggal_pemeriksaan)->format('d-m-Y') }}
                                            </td>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                {{ Str::limit($catatan->keluhan_utama, 50) }}
                                            </td>
                                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                <div class="flex items-center space-x-2">
                                                    <a href="{{ route('dokter.catatan_medis.show', ['catatanMedis' => $catatan->id]) }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded text-xs">
                                                        {{ __('Detail') }}
                                                    </a>
                                                    <a href="{{ route('dokter.catatan_medis.edit', ['catatanMedis' => $catatan->id]) }}" class="inline-block bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded text-xs">
                                                        {{ __('Edit') }}
                                                    </a>
                                                    <form action="{{ route('dokter.catatan_medis.destroy', ['catatanMedis' => $catatan->id]) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded text-xs" onclick="return confirm('{{ __('Apakah Anda yakin ingin menghapus catatan ini?') }}')">
                                                            {{ __('Hapus') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{ $catatanMedis->links() }} {{-- Jika Anda menggunakan pagination --}}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

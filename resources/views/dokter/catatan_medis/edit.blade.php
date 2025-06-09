@extends('layouts.dokter')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Catatan Medis') }}
    </h2>
@endsection

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 space-y-4">
                    <h3 class="text-lg font-semibold mb-4 text-gray-700">{{ __('Formulir Edit Catatan Medis') }}</h3>
                    <form action="{{ route('dokter.catatan_medis.update', ['catatanMedis' => $catatanMedis->id]) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="pasien_id" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Nama Pasien') }}</label>
                            <input type="text" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="pasien_id" value="{{ $catatanMedis->pasien->nama }}" readonly>
                        </div>

                        <div>
                            <label for="tanggal_pemeriksaan" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Tanggal Pemeriksaan') }}</label>
                            <input type="date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="tanggal_pemeriksaan" name="tanggal_pemeriksaan" value="{{ $catatanMedis->tanggal_pemeriksaan }}" required>
                        </div>

                        <div>
                            <label for="keluhan_utama" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Keluhan Utama') }}</label>
                            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="keluhan_utama" name="keluhan_utama" rows="3" required>{{ $catatanMedis->keluhan_utama }}</textarea>
                        </div>

                        <div>
                            <label for="diagnosa" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Diagnosa') }}</label>
                            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="diagnosa" name="diagnosa" rows="3">{{ $catatanMedis->diagnosa }}</textarea>
                        </div>

                        <div>
                            <label for="tindakan" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Tindakan') }}</label>
                            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="tindakan" name="tindakan" rows="3">{{ $catatanMedis->tindakan }}</textarea>
                        </div>

                        <div>
                            <label for="resep" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Resep Obat') }}</label>
                            <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="resep" name="resep" rows="3">{{ $catatanMedis->resep }}</textarea>
                        </div>

                        <div class="flex items-center justify-end space-x-2">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                {{ __('Update Catatan Medis') }}
                            </button>
                            <a href="{{ route('dokter.catatan_medis.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                {{ __('Batal') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

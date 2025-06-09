<!DOCTYPE html>
<html>

<head>
    <title>Rekam Medis - {{ $pasien->nama ?? 'Data Tidak Ditemukan' }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            line-height: 1.5;
            margin: 20mm;
            /* Atur margin yang sesuai */
            padding: 0;
            /* Pastikan tidak ada padding yang tidak diinginkan */
            position: relative;
            /* Penting untuk positioning footer */
            min-height: 100%;
            /* Pastikan body setidaknya setinggi halaman */
        }

        h1,
        h2,
        h3 {
            margin-top: 18px;
            margin-bottom: 8px;
            color: #333;
            page-break-after: avoid;
        }

        h1 {
            font-size: 18pt;
            text-align: center;
            margin-bottom: 20px;
        }

        h2 {
            font-size: 13pt;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }

        h3 {
            font-size: 11pt;
        }

        .section {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
            page-break-inside: avoid;
            /* Cegah section terpotong */
        }

        .section p {
            margin: 5px 0;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 15px;
            page-break-inside: avoid;
            /* Cegah tabel terpotong */
        }

        .data-table th,
        .data-table td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
            vertical-align: top;
            word-wrap: break-word;
        }

        .data-table th {
            background-color: #e9e9e9;
            font-weight: bold;
            font-size: 9pt;
        }

        .data-table td {
            font-size: 9pt;
        }

        .data-table tr:nth-child(even) {
            background-color: #f5f5f5;
        }

        .odontogram-chart {
            display: block;
            max-width: 100%;
            height: auto;
            margin: 20px auto 10px auto;
            border: 1px solid #ddd;
            padding: 5px;
            page-break-inside: avoid;
            /* Cegah gambar terpotong */
        }

        .no-data {
            font-style: italic;
            color: #666;
            margin-top: 10px;
        }

        .footer {
            position: fixed;
            bottom: 0;
            /* Ubah ke 0 untuk menempel di bawah */
            left: 0;
            right: 0;
            height: auto;
            /* Biarkan tinggi menyesuaikan konten */
            min-height: 20mm;
            /* Tinggi minimum */
            font-size: 8pt;
            color: #555;
            text-align: center;
            border-top: 1px solid #eee;
            padding-top: 5px;
            padding-bottom: 5px;
            z-index: 1000;
            /* Pastikan di atas elemen lain */
        }

        .footer p {
            margin: 2px 0;
        }

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <h1>Rekam Medis Pasien</h1>

    <div class="section">
        <h2>Informasi Pasien</h2>
        <p><strong>Nama:</strong> {{ $pasien->nama ?? '-' }}</p>
        <p><strong>Tempat/Tanggal Lahir:</strong>
            {{ $pasien->tempat_lahir ?? '-' }}/{{ $pasien->tanggal_lahir ? \Carbon\Carbon::parse($pasien->tanggal_lahir)->format('d-m-Y') : '-' }}
        </p>
        <p><strong>Jenis Kelamin:</strong> {{ $pasien->jenis_kelamin ?? '-' }}</p>
        <p><strong>Alamat:</strong> {{ $pasien->alamat ?? '-' }}</p>
        <p><strong>No. HP:</strong> {{ $pasien->no_hp ?? '-' }}</p>
    </div>

    <div class="section">
        <h2>Riwayat Catatan Medis</h2>
        @if ($catatanMedis->isEmpty())
            <p class="no-data">Tidak ada catatan medis untuk pasien ini.</p>
        @else
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Tanggal Pemeriksaan</th>
                        <th>Keluhan Utama</th>
                        <th>Diagnosa</th>
                        <th>Tindakan</th>
                        <th>Resep</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($catatanMedis as $catatan)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($catatan->tanggal_pemeriksaan)->format('d-m-Y') }}</td>
                            <td>{{ $catatan->keluhan_utama ?? '-' }}</td>
                            <td>{{ $catatan->diagnosa ?? '-' }}</td>
                            <td>{{ $catatan->tindakan ?? '-' }}</td>
                            <td>{{ $catatan->resep ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="section">
        <h2>Riwayat Odontogram</h2>

        {{--  Bagian Gambar Odontogram (DIPINDAH KE ATAS) --}}
        @if ($odontogramChartBase64)
            <img src="{{ 'data:image/jpeg;base64,' . $odontogramChartBase64 }}" alt="Bagan Odontogram"
                class="odontogram-chart">
        @else
            <p class="no-data">Gambar Bagan Odontogram tidak tersedia.</p>
        @endif

        {{--  Bagian Tabel Odontogram (DIPINDAH KE BAWAH) --}}
        @if ($odontograms->isEmpty())
            <p class="no-data">Belum ada data Odontogram untuk pasien ini.</p>
        @else
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>No. Gigi</th>
                        <th>Kondisi Gigi</th>
                        <th>Oklusi</th>
                        <th>Lain-lain</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($odontograms as $odonto)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($odonto->tanggal_pemeriksaan)->format('d-m-Y') }}</td>
                            <td>{{ $odonto->nomor_gigi ?? '-' }}</td>
                            <td>{{ $odonto->kondisi_gigi ?? '-' }}</td>
                            <td>{{ $odonto->occlusi ?? '-' }}</td>
                            <td>
                                @if ($odonto->torus_palatinus)
                                    Torus Palatinus: {{ $odonto->torus_palatinus }}<br>
                                @endif
                                @if ($odonto->torus_mandibularis)
                                    Torus Mandibularis: {{ $odonto->torus_mandibularis }}<br>
                                @endif
                                @if ($odonto->palatum)
                                    Palatum: {{ $odonto->palatum }}<br>
                                @endif
                                @if ($odonto->diastema)
                                    Diastema: {{ $odonto->diastema }}<br>
                                @endif
                                @if ($odonto->gigi_anomali)
                                    Gigi Anomali: {{ $odonto->gigi_anomali }}<br>
                                @endif
                                @if ($odonto->lain_lain)
                                    Lain-lain: {{ $odonto->lain_lain }}<br>
                                @endif
                                @if ($odonto->jumlah_foto_rontgen)
                                    Jumlah Foto Rontgen: {{ $odonto->jumlah_foto_rontgen }}
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <div class="footer">
        <p>Dokumen ini dibuat secara otomatis oleh Sistem Informasi Rekam Medis Poli Gigi.</p>
        <p>Klinik Gigi | Tambakromo I, Tambakromo, Kec. Geneng, Kabupaten Ngawi, Jawa Timur</p>
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->translatedFormat('d F Y H:i:s') }}</p>
    </div>

</body>

</html>

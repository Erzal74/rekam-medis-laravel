{{-- resources/views/admin/dashboard_content.blade.php --}}
@extends('layouts.admin') {{-- Pastikan ini mengacu pada layout admin Anda yang benar --}}

@section('title', 'Dashboard Admin')
@section('header', 'Dashboard Admin')

@section('content')
    <div class="row">
        {{-- Card Total Pasien --}}
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <div class="card card-modern h-100 shadow-sm border-0">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="icon-box-modern bg-gradient-primary text-white me-4">
                        <i class="fas fa-users"></i>
                    </div>
                    <div>
                        <h5 class="card-title text-uppercase text-muted mb-1 fs-6 fw-semibold">Total Pasien</h5>
                        <p class="card-text fs-3 fw-bold text-dark mb-0">{{ $totalPasien }}</p>
                    </div>
                </div>
            </div>
        </div>
        {{-- Card Total Kunjungan --}}
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <div class="card card-modern h-100 shadow-sm border-0">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="icon-box-modern bg-gradient-success text-white me-4">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div>
                        <h5 class="card-title text-uppercase text-muted mb-1 fs-6 fw-semibold">Total Kunjungan</h5>
                        <p class="card-text fs-3 fw-bold text-dark mb-0">{{ $totalKunjungan }}</p>
                    </div>
                </div>
            </div>
        </div>
        {{-- Card Kunjungan Hari Ini --}}
        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
            <div class="card card-modern h-100 shadow-sm border-0">
                <div class="card-body d-flex align-items-center p-4">
                    <div class="icon-box-modern bg-gradient-info text-white me-4">
                        <i class="fas fa-notes-medical"></i>
                    </div>
                    <div>
                        <h5 class="card-title text-uppercase text-muted mb-1 fs-6 fw-semibold">Kunjungan Hari Ini</h5>
                        <p class="card-text fs-3 fw-bold text-dark mb-0">{{ count($riwayatKunjungan) }} Data</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Grafik Kunjungan --}}
        <div class="col-lg-6 mb-4">
            <div class="card card-modern shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
                    <h5 class="mb-0 fw-semibold text-dark">Grafik Kunjungan (4 Bulan Terakhir)</h5>
                </div>
                <div class="card-body pt-3 px-4">
                    <canvas id="grafikKunjungan"></canvas>
                </div>
            </div>
        </div>
        {{-- Riwayat Kunjungan Hari Ini (Tabel) --}}
        <div class="col-lg-6 mb-4">
            <div class="card card-modern shadow-sm border-0 h-100">
                <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
                    <h5 class="mb-0 fw-semibold text-dark">Riwayat Kunjungan Hari Ini</h5>
                </div>
                <div class="card-body pt-3 px-4">
                    @if (count($riwayatKunjungan) > 0)
                        <div class="table-responsive" style="max-height: 380px; overflow-y: auto;">
                            <table class="table table-hover table-striped mb-0 small">
                                <thead class="bg-white sticky-top">
                                    <tr>
                                        <th class="py-2">#</th>
                                        <th class="py-2">Waktu</th>
                                        <th class="py-2">Nama Pasien</th>
                                        <th class="py-2">ID Kunjungan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($riwayatKunjungan as $key => $kunjungan)
                                        <tr>
                                            <td class="py-2">{{ $key + 1 }}</td>
                                            <td class="py-2">{{ $kunjungan['jam_kunjungan'] }}</td>
                                            <td class="py-2">{{ $kunjungan['nama_pasien'] ?? 'N/A' }}</td>
                                            <td class="py-2">{{ $kunjungan['id'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-muted py-4">Belum ada kunjungan hari ini.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Bootstrap Modal untuk Pop-up Selamat Datang --}}
    @if (session('show_welcome_popup'))
        <div class="modal fade" id="welcomeModal" tabindex="-1" aria-labelledby="welcomeModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content shadow-lg rounded-4">
                    <div class="modal-header bg-primary text-white border-0">
                        <h5 class="modal-title fs-5 fw-bold" id="welcomeModalLabel"><i
                                class="fas fa-hand-sparkles me-2"></i>Selamat Datang, Admin!</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 text-center">
                        <p class="lead mb-3">Anda berhasil login ke Dashboard Admin Sistem Rekam Medis Poli Gigi.</p>
                        <p class="text-muted">Siap untuk mengelola data pasien dan kunjungan hari ini?</p>
                    </div>
                    <div class="modal-footer justify-content-center border-0 pb-4">
                        <button type="button" class="btn btn-primary btn-lg rounded-pill px-4"
                            data-bs-dismiss="modal">Mulai Jelajah</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('styles')
    {{-- Custom CSS untuk tampilan lebih rapi dan modern --}}
    <style>
        body {
            background-color: #f8f9fa;
            /* Light background for modern feel */
        }

        .card-modern {
            border-radius: 1rem;
            /* Rounded corners */
            transition: all 0.3s ease;
            overflow: hidden;
            /* Ensure content stays within rounded corners */
        }

        .card-modern:hover {
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1) !important;
            /* Slightly more pronounced shadow on hover */
        }

        .icon-box-modern {
            width: 80px;
            /* Larger icon box */
            height: 80px;
            border-radius: 1rem;
            /* Rounded corners for icon box */
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 2.5rem;
            /* Larger icon */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            /* Shadow for icon box */
        }

        /* Gradient backgrounds for icon boxes */
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .bg-gradient-success {
            background: linear-gradient(135deg, #2ED06E 0%, #17A2B8 100%);
        }

        .bg-gradient-info {
            background: linear-gradient(135deg, #00C6FF 0%, #0072FF 100%);
        }

        .card-modern .card-title {
            font-weight: 500;
        }

        /* Scrollable table for history */
        .table-responsive {
            border-radius: 0.75rem;
            /* Match card border-radius */
            border: 1px solid rgba(0, 0, 0, .05);
            /* subtle border */
        }

        .table-responsive table thead th {
            border-bottom: 2px solid rgba(0, 0, 0, .1);
        }

        .table-responsive table tbody tr:last-child td {
            border-bottom: none;
            /* No border for the last row */
        }

        .table-responsive table td,
        .table-responsive table th {
            white-space: nowrap;
            /* Prevent text wrapping in table cells */
        }

        /* Adjust modal specifics for a cleaner look */
        #welcomeModal .modal-content {
            border-radius: 1.25rem;
            /* Slightly less rounded than card-modern, but still soft */
        }

        #welcomeModal .modal-header {
            padding: 1.5rem;
            border-top-left-radius: 1.25rem;
            border-top-right-radius: 1.25rem;
        }

        #welcomeModal .modal-body {
            padding: 2rem 1.5rem;
        }

        #welcomeModal .modal-footer {
            padding-bottom: 1.5rem;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    {{-- Pastikan Bootstrap JS atau bundle-nya dimuat sebelum ini. Biasanya di layout admin. --}}
    {{-- Contoh (jika Anda menggunakan Bootstrap 5):
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    --}}

    <script>
        // Data for Grafik Kunjungan (4 Bulan Terakhir)
        const grafikKunjunganLabels = @json(array_column($grafikKunjungan, 'bulan'));
        const grafikKunjunganData = @json(array_column($grafikKunjungan, 'jumlah'));

        const grafikKunjunganCanvas = document.getElementById('grafikKunjungan').getContext('2d');
        const grafikKunjunganChart = new Chart(grafikKunjunganCanvas, {
            type: 'line',
            data: {
                labels: grafikKunjunganLabels,
                datasets: [{
                    label: 'Jumlah Kunjungan',
                    data: grafikKunjunganData,
                    backgroundColor: 'rgba(54, 162, 235, 0.1)', // Lebih transparan
                    borderColor: 'rgba(54, 162, 235, 0.8)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4 // Lebih melengkung
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: true,
                            color: 'rgba(0, 0, 0, 0.05)'
                        },
                        ticks: {
                            precision: 0
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false,
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(0, 0, 0, 0.85)', // Background tooltip lebih gelap
                        titleColor: '#fff',
                        bodyColor: '#fff',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1,
                        cornerRadius: 6, // Sudut tooltip lebih bulat
                        padding: 12
                    }
                }
            }
        });

        // ====================================================================
        // Popup Logic (MENGGUNAKAN BOOTSTRAP MODAL JS)
        // ====================================================================

        // Fungsi untuk menampilkan modal
        function showBootstrapWelcomeModal() {
            // Cek apakah ada flash message 'show_welcome_popup' dari controller
            const showViaSession = {{ session()->has('show_welcome_popup') ? 'true' : 'false' }};

            if (showViaSession) {
                // Pastikan Bootstrap JS sudah dimuat
                const welcomeModal = new bootstrap.Modal(document.getElementById('welcomeModal'));
                welcomeModal.show();
            }
        }

        // Panggil fungsi untuk menampilkan modal saat dokumen siap (DOM content loaded)
        // Ini lebih baik daripada window.onload karena akan berjalan lebih cepat
        document.addEventListener('DOMContentLoaded', function() {
            showBootstrapWelcomeModal();
        });
    </script>
@endpush

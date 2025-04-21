{{-- resources/views/admin/dashboard_content.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('header', 'Dashboard Admin')

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="info-box">
                <i class="fas fa-users"></i>
                <div>
                    <h4>Total Pasien</h4>
                    <p>{{ $totalPasien }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box">
                <i class="fas fa-calendar-check"></i>
                <div>
                    <h4>Total Kunjungan</h4>
                    <p>{{ $totalKunjungan }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box">
                <i class="fas fa-history"></i>
                <div>
                    <h4>Riwayat Kunjungan</h4>
                    <p>{{ count($riwayatKunjungan) }} Data</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="chart-container">
                <h5>Grafik Kunjungan</h5>
                <canvas id="grafikKunjungan"></canvas>
            </div>
        </div>
        <div class="col-md-6">
            <div class="chart-container">
                <h5>Riwayat Kunjungan</h5>
                <canvas id="riwayatKunjunganChart"></canvas>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const grafikKunjunganCanvas = document.getElementById('grafikKunjungan').getContext('2d');
        const grafikKunjunganChart = new Chart(grafikKunjunganCanvas, {
            type: 'line',
            data: {
                labels: @json(array_column($grafikKunjungan, 'bulan')),
                datasets: [{
                    label: 'Jumlah Kunjungan',
                    data: @json(array_column($grafikKunjungan, 'jumlah')),
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: false,
                    }
                }
            }
        });

        const riwayatKunjunganCanvas = document.getElementById('riwayatKunjunganChart').getContext('2d');
        const riwayatKunjunganChart = new Chart(riwayatKunjunganCanvas, {
            type: 'bar',
            data: {
                labels: @json(array_column($riwayatKunjungan, 'bulan')),
                datasets: [{
                    label: 'Riwayat Kunjungan',
                    data: @json(array_column($riwayatKunjungan, 'jumlah')),
                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: false,
                    }
                }
            }
        });

        function showWelcomePopup() {
            const popupOverlay = document.getElementById('popupOverlay');
            const hasSeenPopup = localStorage.getItem('adminWelcomePopupShown');

            if (!hasSeenPopup) {
                popupOverlay.style.display = 'flex';
                localStorage.setItem('adminWelcomePopupShown', 'true');
            } else {
                popupOverlay.style.display = 'none'; // Pastikan tidak muncul lagi jika sudah dilihat
            }
        }

        function closePopup() {
            const popupOverlay = document.getElementById('popupOverlay');
            popupOverlay.style.display = 'none';
        }

        // Munculkan pop-up saat halaman pertama kali dimuat setelah login
        window.onload = showWelcomePopup;
    </script>
@endpush

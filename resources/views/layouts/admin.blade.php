<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            background-color: #2c3e50;
            color: white;
            width: 220px;
            padding-top: 20px;
            flex-shrink: 0;
        }

        .sidebar h5 {
            padding: 15px 20px;
            margin-bottom: 0;
            color: #ecf0f1;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 14px;
        }

        .sidebar a {
            padding: 12px 20px;
            display: block;
            color: #ecf0f1;
            text-decoration: none;
            transition: background-color 0.3s ease;
            font-size: 15px;
        }

        .sidebar a:hover {
            background-color: #34495e;
        }

        .content-wrapper {
            flex-grow: 1;
            padding: 20px;
            background-color: #ecf0f1;
            position: relative; /* Untuk menampung pop-up secara relatif */
        }

        .header {
            background-color: #3498db;
            color: white;
            padding: 15px 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-radius: 5px;
            z-index: 10; /* Pastikan header di atas overlay */
        }

        .header h2 {
            margin: 0;
            font-size: 22px;
            font-weight: bold;
        }

        .header .btn-logout {
            background-color: #e74c3c;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s ease;
            z-index: 11; /* Pastikan tombol logout di atas pop-up */
        }

        .header .btn-logout:hover {
            background-color: #c0392b;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Efek blur di belakang */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 50; /* Di atas konten, di bawah header */
            display: none; /* Sembunyikan overlay secara default */
        }

        .popup {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 300px; /* Sesuaikan lebar pop-up */
            position: relative;
        }

        .popup h4 {
            color: #333;
            margin-top: 0;
            margin-bottom: 15px;
        }

        .popup p {
            color: #555;
            margin-bottom: 20px;
        }

        .popup-close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 18px;
            cursor: pointer;
            color: #777;
            opacity: 0.7;
            transition: opacity 0.2s ease-in-out;
        }

        .popup-close-btn:hover {
            opacity: 1;
            color: #333;
        }

        .content {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,.1);
            margin-bottom: 20px;
            border-radius: 5px;
            z-index: 1; /* Di bawah pop-up dan overlay */
        }

        .info-box {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 15px;
            border: 1px solid #eee;
            display: flex;
            align-items: center;
        }

        .info-box i {
            font-size: 24px;
            margin-right: 10px;
            color: #3498db;
        }

        .info-box h4 {
            margin-top: 0;
            color: #333;
            font-size: 18px;
            margin-bottom: 5px;
        }

        .info-box p {
            font-size: 16px;
            color: #555;
            margin-bottom: 0;
        }

        .chart-container {
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,.1);
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .chart-container h5 {
            margin-top: 0;
            margin-bottom: 15px;
            color: #333;
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h5>Menu</h5>
        <a href="{{ route('admin.dashboard') }}" class="nav-link"><i class="fas fa-home me-2"></i> Home</a>
        <a href="{{ route('admin.pasien.index') }}" class="nav-link"><i class="fas fa-user-plus me-2"></i> Data Pasien</a>
        {{-- PERBAIKAN DI SINI: Link mengarah ke rute jadwal dokter admin --}}
        <a href="{{ route('admin.schedules.index') }}" class="nav-link"><i class="fas fa-calendar-alt me-2"></i> Jadwal Dokter </a>
    </div>

    <div class="content-wrapper">
        <div class="header">
            <h2>@yield('header')</h2>
            <a href="/logout" class="btn-logout">Logout</a>
        </div>

        <div id="popupOverlay" class="overlay" style="display: none;">
            <div class="popup">
                <button class="popup-close-btn" onclick="closePopup()">&times;</button>
                <h4>Selamat Datang, Admin!</h4>
                <p>Anda berhasil masuk ke Dashboard Admin. Selamat bekerja!</p>
            </div>
        </div>

        <div class="content">
            @yield('content')
        </div>
    </div>

    @stack('scripts')
    <script>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

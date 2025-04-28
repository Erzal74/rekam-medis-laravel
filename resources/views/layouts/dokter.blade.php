<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Dokter')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            background-color: #1e88e5; /* Warna tema dokter */
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
            background-color: #29b6f6;
        }

        .content-wrapper {
            flex-grow: 1;
            padding: 20px;
            background-color: #e3f2fd; /* Warna latar belakang content dokter */
        }

        .header {
            background-color: #29b6f6; /* Warna header dokter */
            color: white;
            padding: 15px 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .header h2 {
            margin: 0;
            font-size: 22px;
            font-weight: bold;
        }

        .header .btn-logout {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .header .btn-logout:hover {
            background-color: #e53935;
        }

        .content {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,.1);
        }

        .popup-peringatan {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            z-index: 1000;
            text-align: center;
        }

        .popup-peringatan-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .popup-peringatan-header h6 {
            margin: 0;
            font-weight: bold;
        }

        .popup-peringatan-header button {
            background: none;
            border: none;
            color: #721c24;
            font-size: 1.2em;
            cursor: pointer;
        }

        .popup-peringatan-body {
            margin-bottom: 10px;
        }

        .popup-peringatan-footer button {
            margin-top: 10px;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #dc3545;
            color: white;
        }

        .popup-sukses {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
            z-index: 1001;
            text-align: center;
        }

        .popup-sukses-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .popup-sukses-header h6 {
            margin: 0;
            font-weight: bold;
        }

        .popup-sukses-header button {
            background: none;
            border: none;
            color: #155724;
            font-size: 1.2em;
            cursor: pointer;
        }

        .popup-sukses-body {
            margin-bottom: 10px;
        }

        .popup-sukses-footer button {
            margin-top: 10px;
            padding: 8px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #28a745;
            color: white;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h5>Menu Dokter</h5>
        <a href="{{ route('dokter.dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
        <a href="{{ route('dokter.schedules.index') }}"><i class="fas fa-calendar-alt me-2"></i> Jadwal Saya</a>
        <a href="#"><i class="fas fa-notes-medical me-2"></i> Catatan Medis</a>
        <a href="#"><i class="fas fa-user-injured me-2"></i> Rekam Medis</a>
    </div>

    <div class="content-wrapper">
        <div class="header">
            <h2>@yield('header')</h2>
            <a href="{{ route('logout') }}" class="btn-logout">Logout</a>
        </div>

        <div class="popup-peringatan" id="popupPeringatan">
            <div class="popup-peringatan-header">
                <h6>Peringatan</h6>
                <button onclick="tutupPeringatan('popupPeringatan')">&times;</button>
            </div>
            <div class="popup-peringatan-body">
                <p id="pesanPeringatan">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    @endif
                </p>
            </div>
            <div class="popup-peringatan-footer">
                <button onclick="tutupPeringatan('popupPeringatan')">OK</button>
            </div>
        </div>

        <div class="popup-sukses" id="popupSukses">
            <div class="popup-sukses-header">
                <h6>Sukses</h6>
                <button onclick="tutupPeringatan('popupSukses')">&times;</button>
            </div>
            <div class="popup-sukses-body">
                @if (session('success'))
                    <p>{{ session('success') }}</p>
                @endif
            </div>
            <div class="popup-sukses-footer">
                <button onclick="tutupPeringatan('popupSukses')">OK</button>
            </div>
        </div>

        <div class="content">
            @yield('content')
        </div>
    </div>

    <script>
        function tutupPeringatan(popupId) {
            document.getElementById(popupId).style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', function() {
            const popupPeringatan = document.getElementById('popupPeringatan');
            const popupSukses = document.getElementById('popupSukses');

            @if ($errors->any())
                popupPeringatan.style.display = 'block';
            @endif

            @if (session('success'))
                popupSukses.style.display = 'block';
            @endif
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

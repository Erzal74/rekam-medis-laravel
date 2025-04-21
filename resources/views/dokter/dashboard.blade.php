<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dokter</title>
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

        .doctor-profile {
            background-color: #fff;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,.1);
            margin-bottom: 20px;
            text-align: center;
        }

        .doctor-profile h4 {
            margin-top: 0;
            color: #333;
            margin-bottom: 5px;
        }

        .doctor-profile p {
            color: #777;
            font-size: 14px;
            margin-bottom: 0;
        }

        .info-box {
            background-color: #fff;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 1px 3px rgba(0,0,0,.1);
            margin-bottom: 20px;
        }

        .info-box h5 {
            margin-top: 0;
            color: #333;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .patient-count {
            font-size: 24px;
            color: #1e88e5;
            margin-bottom: 5px;
        }

        .patient-details {
            font-size: 16px;
            color: #555;
        }

        .schedule-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .schedule-item:last-child {
            border-bottom: none;
        }

        .schedule-item span {
            color: #333;
        }

        .todo-list ul {
            padding-left: 20px;
            margin-bottom: 0;
        }

        .todo-list li {
            color: #555;
            margin-bottom: 8px;
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

        .todo-actions a, .todo-actions form {
            display: inline-block;
            margin-left: 5px;
        }
        .todo-actions button {
            border: none;
            background: none;
            color: #dc3545;
            cursor: pointer;
            padding: 0;
        }
        .todo-actions button:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h5>Menu Dokter</h5>
        <a href="#"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
        <a href="#"><i class="fas fa-calendar-alt me-2"></i> Jadwal Saya</a>
        <a href="#"><i class="fas fa-notes-medical me-2"></i> Catatan Medis</a>
        <a href="#"><i class="fas fa-user-injured me-2"></i> Rekam Medis</a>
    </div>

    <div class="content-wrapper">
        <div class="header">
            <h2>Dashboard Dokter</h2>
            <a href="/logout" class="btn-logout">Logout</a>
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

        <div class="doctor-profile">
            <h4>Dr.Erlyn Aprilia {{ $dokter->nama }}</h4>
            <p><i class="fas fa-user-md me-2"></i> Spesialis Gigi {{ $dokter->spesialisasi }}</p>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="info-box">
                    <h5>Jumlah Pasien Hari Ini</h5>
                    <p class="patient-count">
                        <i class="fas fa-users me-2"></i> <span>{{ $jumlahPasienHariIni }}</span>
                    </p>
                    <p class="patient-details">
                        <i class="fas fa-user me-2"></i> Pasien Lama: <span>{{ $jumlahPasienLamaHariIni }}</span>
                    </p>
                    <p class="patient-details">
                        <i class="fas fa-user-plus me-2"></i> Pasien Baru: <span>{{ $jumlahPasienBaruHariIni }}</span>
                    </p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-box">
                    <h5>Jadwal Kunjungan Hari Ini</h5>
                    <div id="jadwalKunjungan">
                        @if ($jadwalKunjunganHariIni->count() > 0)
                            @foreach ($jadwalKunjunganHariIni as $jadwal)
                                <div class="schedule-item">
                                    <span>{{ \Carbon\Carbon::parse($jadwal->waktu_kunjungan)->format('H:i') }}</span> - <span>{{ $jadwal->pasien->nama }}</span>
                                </div>
                            @endforeach
                        @else
                            <p>Tidak ada jadwal kunjungan hari ini.</p>
                        @endif
                    </div>
                </div>
            </div>
            <div class="info-box todo-list">
                <h5>To-Do List</h5>
                <form action="{{ route('dokter.todo.store') }}" method="POST" class="mb-3">
                    @csrf
                    <div class="input-group">
                        <input type="text" name="deskripsi" class="form-control" placeholder="Tambahkan catatan baru...">
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
                <ul class="list-group">
                    @forelse ($todoList as $todo)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>{{ $todo->deskripsi }}</span>
                            <div class="todo-actions">
                                <a href="{{ route('dokter.todo.edit', $todo->id) }}" class="btn btn-sm btn-warning me-2"><i class="fas fa-edit"></i> Edit</a>
                                <form action="{{ route('dokter.todo.destroy', $todo->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus catatan ini?')"><i class="fas fa-trash-alt"></i> Hapus</button>
                                </form>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item">Tidak ada catatan.</li>
                    @endforelse
                </ul>
            </div>
        </div>

    <script>
        // const jadwalKunjunganDiv = document.getElementById('jadwalKunjungan');
        // const jadwalHariIni = [
        //     { waktu: '09:00', pasien: 'Ahmad Wijaya' },
        //     { waktu: '09:30', pasien: 'Siti Aminah' },
        //     { waktu: '10:00', pasien: 'Budi Santoso' },
        //     // ... data jadwal lainnya
        // ];

        // if (jadwalHariIni.length > 0) {
        //     jadwalKunjunganDiv.innerHTML = ''; // Bersihkan pesan default
        //     jadwalHariIni.forEach(item => {
        //         const jadwalItem = document.createElement('div');
        //         jadwalItem.classList.add('schedule-item');
        //         jadwalItem.innerHTML = `<span>${item.waktu}</span> - <span>${item.pasien}</span>`;
        //         jadwalKunjunganDiv.appendChild(jadwalItem);
        //     });
        // }

        function tutupPeringatan(popupId) {
            document.getElementById(popupId).style.display = 'none';
        }

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
</body>
</html>

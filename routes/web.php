<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\DoctorScheduleController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Rute ROOT '/' akan selalu mengarahkan ke halaman login
Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('home');
    }
    return redirect()->route('login');
});

// Rute Autentikasi (Login)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
});

// Rute Home - Redirect berdasarkan Role (diakses setelah login berhasil)
Route::get('/home', function () {
    $user = Auth::user();
    if ($user) {
        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'dokter') {
            return redirect()->route('dokter.dashboard');
        } else {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Role pengguna tidak dikenali.');
        }
    }
    return redirect()->route('login')->with('error', 'Pengguna tidak terautentikasi.');
})->name('home')->middleware('auth');

// Grup Rute yang Membutuhkan Autentikasi (setelah login)
Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware([RoleMiddleware::class . ':admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        // Rute Pasien
        Route::get('/pasien', [AdminController::class, 'pasienIndex'])->name('pasien.index');
        Route::get('/pasien/create', [AdminController::class, 'pasienCreate'])->name('pasien.create');
        Route::post('/pasien', [AdminController::class, 'pasienStore'])->name('pasien.store');
        Route::get('/pasien/{pasien}/edit', [AdminController::class, 'pasienEdit'])->name('pasien.edit');
        Route::put('/pasien/{pasien}', [AdminController::class, 'pasienUpdate'])->name('pasien.update');
        Route::delete('/pasien/{pasien}', [AdminController::class, 'pasienDestroy'])->name('pasien.destroy');

        // Rute Jadwal Dokter Admin
        Route::get('/schedules', [AdminController::class, 'scheduleIndex'])->name('schedules.index');
    });

    Route::middleware([RoleMiddleware::class . ':dokter'])->prefix('dokter')->name('dokter.')->group(function () {
        Route::get('/dashboard', [DokterController::class, 'index'])->name('dashboard');
        Route::resource('schedules', DoctorScheduleController::class);

        // Rute To-Do List Dokter
        Route::post('/todo', [DokterController::class, 'storeTodo'])->name('todo.store');
        Route::get('/todo/{todo}/edit', [DokterController::class, 'editTodo'])->name('todo.edit');
        Route::put('/todo/{todo}', [DokterController::class, 'updateTodo'])->name('todo.update');
        Route::delete('/todo/{todo}', [DokterController::class, 'destroyTodo'])->name('todo.destroy');

        // Rute Catatan Medis Dokter
        Route::get('/catatan-medis', [DokterController::class, 'daftarCatatanMedis'])->name('catatan_medis.index');
        Route::get('/catatan-medis/create', [DokterController::class, 'createCatatanMedis'])->name('catatan_medis.create');
        Route::post('/catatan-medis', [DokterController::class, 'storeCatatanMedis'])->name('catatan_medis.store');
        Route::get('/catatan-medis/{catatanMedis}', [DokterController::class, 'showCatatanMedis'])->name('catatan_medis.show');
        Route::get('/catatan-medis/{catatanMedis}/edit', [DokterController::class, 'editCatatanMedis'])->name('catatan_medis.edit');
        Route::put('/catatan-medis/{catatanMedis}', [DokterController::class, 'updateCatatanMedis'])->name('catatan_medis.update');
        Route::delete('/catatan-medis/{catatanMedis}', [DokterController::class, 'destroyCatatanMedis'])->name('catatan_medis.destroy');

        // Rute Jadwal Saya Dokter
        Route::get('/jadwal-saya', [DokterController::class, 'jadwalSaya'])->name('jadwalSaya');

        // Rute Rekam Medis Dokter
        Route::get('/rekam-medis', [DokterController::class, 'rekamMedisIndex'])->name('rekam_medis.index');
        Route::get('/rekam-medis/show', [DokterController::class, 'rekamMedisShow'])->name('rekam_medis.show');
        Route::get('/rekam-medis/cetak/{pasien_id}', [DokterController::class, 'cetakPdfRekamMedis'])->name('rekam_medis.cetak_pdf');

        // Rute Odontogram Dokter
        Route::prefix('odontograms')->name('odontograms.')->group(function () {
            Route::get('/', [DokterController::class, 'indexOdontogram'])->name('index');
            Route::get('/create', [DokterController::class, 'createOdontogram'])->name('create');
            Route::post('/', [DokterController::class, 'storeOdontogram'])->name('store');
            Route::get('/{odontogram}', [DokterController::class, 'showOdontogram'])->name('show');
            Route::get('/{odontogram}/edit', [DokterController::class, 'editOdontogram'])->name('edit');
            Route::put('/{odontogram}', [DokterController::class, 'updateOdontogram'])->name('update');
            Route::delete('/{odontogram}', [DokterController::class, 'destroyOdontogram'])->name('destroy');
        });
    });
});

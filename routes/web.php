<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DokterController; // Perubahan nama controller
use App\Http\Controllers\DoctorScheduleController; // Pastikan ini ada
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Ini route home yang kamu buat tadi
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
})->name('home');

// Grup Rute untuk pengguna yang sudah login (Authenticated)
Route::middleware('auth')->group(function () {
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    // Grup Rute untuk Admin
    Route::middleware(['auth', RoleMiddleware::class . ':admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        // Rute Pasien (tetap seperti semula)
        Route::get('/pasien', [AdminController::class, 'pasienIndex'])->name('pasien.index');
        Route::get('/pasien/create', [AdminController::class, 'pasienCreate'])->name('pasien.create');
        Route::post('/pasien', [AdminController::class, 'pasienStore'])->name('pasien.store');
        Route::get('/pasien/{pasien}/edit', [AdminController::class, 'pasienEdit'])->name('pasien.edit');
        Route::put('/pasien/{pasien}', [AdminController::class, 'pasienUpdate'])->name('pasien.update');
        Route::delete('/pasien/{pasien}', [AdminController::class, 'pasienDestroy'])->name('pasien.destroy');

        // Rute Jadwal Dokter (Admin hanya bisa melihat)
        Route::get('/schedules', [AdminController::class, 'scheduleIndex'])->name('schedules.index');
    });

    // Grup Rute untuk Dokter
    Route::middleware(['auth', RoleMiddleware::class . ':dokter'])->prefix('dokter')->name('dokter.')->group(function () {
        Route::get('/dashboard', [DokterController::class, 'index'])->name('dashboard'); // Menggunakan DokterController
        Route::get('/jadwal-saya', [DokterController::class, 'jadwalSaya'])->name('schedules.index'); // Menggunakan DokterController
        Route::get('/catatan-medis', [DokterController::class, 'catatanMedis'])->name('medical_notes.index'); // Menggunakan DokterController
        Route::get('/rekam-medis', [DokterController::class, 'rekamMedis'])->name('medical_records.index'); // Menggunakan DokterController

        // Rute untuk To-Do List
        Route::post('/todo', [DokterController::class, 'storeTodo'])->name('todo.store');
        Route::get('/todo/{todo}/edit', [DokterController::class, 'editTodo'])->name('todo.edit');
        Route::put('/todo/{todo}', [DokterController::class, 'updateTodo'])->name('todo.update');
        Route::delete('/todo/{todo}', [DokterController::class, 'destroyTodo'])->name('todo.destroy');

        // Rute Jadwal Dokter (Dokter bisa mengelola jadwalnya)
        Route::resource('schedules', DoctorScheduleController::class); // Tetap menggunakan DoctorScheduleController jika logikanya terpisah
    });
});

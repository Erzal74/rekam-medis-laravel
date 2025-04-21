<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ControllerSessions;
use App\Http\Controllers\DokterDashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Rute untuk pengguna yang belum login (Guest)
Route::middleware(['guest'])->group(function () {
    Route::get('/', [ControllerSessions::class, 'index'])->name('login');
    Route::post('/', [ControllerSessions::class, 'login']);
});

// Rute untuk redirect setelah login (mengarah ke dashboard sesuai role)
Route::get('/home', function () {
    $user = Auth::user();
    if ($user && $user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user && $user->role === 'dokter') {
        return redirect()->route('dokter.dashboard');
    } else {
        Auth::logout();
        return redirect()->route('login')->with('error', 'Role pengguna tidak dikenali.');
    }
})->name('home');

// Grup Rute untuk pengguna yang sudah login (Authenticated)
Route::middleware('auth')->group(function () {
    Route::get('/logout', [ControllerSessions::class, 'logout'])->name('logout');

    // Grup Rute untuk Admin - Tanpa Middleware Role Tambahan
    // Pengecekan role HARUS dilakukan di dalam AdminController.
    Route::prefix('admin')->group(function () { // <<< Middleware role dihapus di sini
        Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

        // Rute Pasien
        Route::get('/pasien', [AdminController::class, 'pasienIndex'])->name('admin.pasien.index');
        Route::get('/pasien/create', [AdminController::class, 'pasienCreate'])->name('admin.pasien.create');
        Route::post('/pasien', [AdminController::class, 'pasienStore'])->name('admin.pasien.store');
        Route::get('/pasien/{pasien}/edit', [AdminController::class, 'pasienEdit'])->name('admin.pasien.edit');
        Route::put('/pasien/{pasien}', [AdminController::class, 'pasienUpdate'])->name('admin.pasien.update');
        Route::delete('/pasien/{pasien}', [AdminController::class, 'pasienDestroy'])->name('admin.pasien.destroy');

        // Rute Jadwal Dokter
        Route::get('/schedules', [AdminController::class, 'scheduleIndex'])->name('admin.schedules.index');
        Route::get('/schedules/create', [AdminController::class, 'scheduleCreate'])->name('admin.schedules.create');
        Route::post('/schedules', [AdminController::class, 'scheduleStore'])->name('admin.schedules.store');
        Route::get('/schedules/{schedule}/edit', [AdminController::class, 'scheduleEdit'])->name('admin.schedules.edit');
        Route::put('/schedules/{schedule}', [AdminController::class, 'scheduleUpdate'])->name('admin.schedules.update');
        Route::delete('/schedules/{schedule}', [AdminController::class, 'scheduleDestroy'])->name('admin.schedules.destroy');
    });

    // Grup Rute untuk Dokter - Tanpa Middleware Role Tambahan
    // Pengecekan role HARUS dilakukan di dalam DokterDashboardController jika diperlukan.
    Route::prefix('dokter')->group(function () { // <<< Middleware role dihapus di sini
        Route::get('/dashboard', [DokterDashboardController::class, 'index'])->name('dokter.dashboard');
        Route::post('/todo', [DokterDashboardController::class, 'storeTodo'])->name('dokter.todo.store');
        Route::get('/todo/{todo}/edit', [DokterDashboardController::class, 'editTodo'])->name('dokter.todo.edit');
        Route::put('/todo/{todo}', [DokterDashboardController::class, 'updateTodo'])->name('dokter.todo.update');
        Route::delete('/todo/{todo}', [DokterDashboardController::class, 'destroyTodo'])->name('dokter.todo.destroy');
    });
});

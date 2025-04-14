<?php

use App\Http\Controllers\AdminDashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerSessions;
use App\Http\Controllers\DokterDashboardController;
use Illuminate\Support\Facades\Auth;

Route::middleware(['guest'])->group(function () {
Route::get('/', [ControllerSessions::class, 'index']);
Route::post('/', [ControllerSessions::class, 'login']);
});

Route::get('/home', function () {
    $user = Auth::user();
    if ($user && $user->role === 'admin') {
        return redirect('/admin/dashboard');
    } elseif ($user && $user->role === 'dokter') {
        return redirect('/dokter/dashboard');
    } else {
        return redirect('/'); // Atau halaman default lainnya
    }
});

Route::middleware('auth')->group(function () {
    Route::get('/logout', [ControllerSessions::class, 'logout']);

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/dokter/dashboard', [DokterDashboardController::class, 'index'])->name('dokter.dashboard');
    Route::post('/dokter/todo', [DokterDashboardController::class, 'storeTodo'])->name('dokter.todo.store');
    Route::get('/dokter/todo/{todo}/edit', [DokterDashboardController::class, 'editTodo'])->name('dokter.todo.edit');
    Route::put('/dokter/todo/{todo}', [DokterDashboardController::class, 'updateTodo'])->name('dokter.todo.update');
    Route::delete('/dokter/todo/{todo}', [DokterDashboardController::class, 'destroyTodo'])->name('dokter.todo.destroy');
});

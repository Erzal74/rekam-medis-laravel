<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerSessions;
use App\Http\Controllers\DokterController;

Route::middleware(['guest'])->group(function () {
Route::get('/', [ControllerSessions::class, 'index']);
Route::post('/', [ControllerSessions::class, 'login']);
});

Route::get('/home', function () {
    return redirect('/admin');
    return redirect('/dokter');
});

Route::middleware('auth')->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
    Route::get('/logout', [ControllerSessions::class, 'logout']);
    Route::get('/dokter', [DokterController::class, 'index']);
});

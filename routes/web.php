<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControllerSessions;

Route::get('/', [ControllerSessions::class, 'index']);
Route::post('/', [ControllerSessions::class, 'login']);

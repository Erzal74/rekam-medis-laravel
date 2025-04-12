<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DokterController extends Controller
{
    public function index()
    {
        echo "Halo, selamat datang dokter";
        echo "<a href='logout'>logout >></a>";
    }
}

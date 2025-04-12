<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    function index(){
        echo"Halo, selamat datang admin";
        echo "<a href='/logout'>logout >></a>";
    }
}

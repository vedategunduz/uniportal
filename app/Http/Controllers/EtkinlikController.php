<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EtkinlikController extends Controller
{
    public function index() {
        return view('main.etkinlik');
    }
}

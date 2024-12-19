<?php

namespace App\Http\Controllers;

use App\Models\Firma;
use App\Models\Kamu;

class TestController extends Controller
{
    protected $veriler;

    public function firmalar() {
        $this->veriler = Firma::all();

        return view('home', ['veriler' => $this->veriler]);
    }

    public function kamular() {
        $this->veriler = Kamu::all();

        return view('home', ['veriler' => $this->veriler]);
    }
}

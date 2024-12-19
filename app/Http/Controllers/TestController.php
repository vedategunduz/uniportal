<?php

namespace App\Http\Controllers;

use App\Models\Firma;

class TestController extends Controller
{
    protected $veriler;

    public function firmalar() {
        $this->veriler = Firma::all();

        return view('home', ['veriler' => $this->veriler]);
    }
}

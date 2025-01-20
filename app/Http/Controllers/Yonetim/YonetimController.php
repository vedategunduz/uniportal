<?php

namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;

class YonetimController extends Controller
{
    public function index()
    {
        return view('yonetim.index');
    }
}

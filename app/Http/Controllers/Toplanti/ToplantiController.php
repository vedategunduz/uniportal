<?php

namespace App\Http\Controllers\Toplanti;

use App\Http\Controllers\Controller;


class ToplantiController extends Controller
{
    public function ziyaretTalep()
    {
        return view('yonetim.toplantilar.index');
    }
}

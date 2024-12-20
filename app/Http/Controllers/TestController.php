<?php

namespace App\Http\Controllers;

use App\Models\EtkinlikTur;
use Illuminate\Http\Request;

class TestController extends Controller
{
    protected $who;

    public function index() {
        return view('home');
    }

    public function EtkinlikTurEkle(Request $request) {
        EtkinlikTur::create([
            'tur' => $request->etkinlik_tur,
            'islem_yapan_id' => 1,
        ]);

        return response()->json('İşlem başarılı');
    }
}

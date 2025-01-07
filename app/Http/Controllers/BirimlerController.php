<?php

namespace App\Http\Controllers;

use App\Models\IsletmeBirim;
use App\Models\IsletmeYetkili;
use Illuminate\Support\Facades\Auth;

class BirimlerController extends Controller
{
    public function index()
    {
        $isletmeler = IsletmeYetkili::where('kullanicilar_id', Auth::user()->kullanicilar_id)->pluck('isletmeler_id');

        $isletmeBirimleri = IsletmeBirim::whereIn('isletmeler_id', $isletmeler)
            ->where('aktiflik', 1)
            ->orderBy('baslik', 'asc')
            ->get();

        return view('kullanici.birimler.index', compact('isletmeBirimleri'));
    }

    public function isletmeBirimPersonelBul($id)
    {
        $personel = (new IsletmeBirim)->isletmeBirimPersonelBul($id);
    }
}

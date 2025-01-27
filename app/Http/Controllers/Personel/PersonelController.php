<?php

namespace App\Http\Controllers\Personel;

use App\Http\Controllers\Controller;
use App\Models\Kullanici;
use App\Models\KullaniciBirimUnvan;

class PersonelController extends Controller
{
    public function show(string $kullanici_id)
    {
        $decryptedKullanicilarId = decrypt($kullanici_id);

        $kullanici = Kullanici::find($decryptedKullanicilarId);

        $isletme = $kullanici->isletme()->first();

        $birimDetaylari = KullaniciBirimUnvan::with('unvan', 'birim')->where('kullanicilar_id', $decryptedKullanicilarId)->get();

        $sonGirisler = $kullanici->sonGirisler()->get();

        return view('personel.profil', [
            'kullanici' => $kullanici,
            'birimDetaylari' => $birimDetaylari,
            'sonGirisler' => $sonGirisler,
            'isletme' => $isletme
        ]);
    }
}

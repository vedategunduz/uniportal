<?php

namespace App\Http\Controllers\Yonetim;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Models\IsletmeYetkili;
use App\Models\Kullanici;
use App\Models\KullaniciBirimUnvan;

class KullaniciController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('yonetim.kullanicilar.index');
    }

    public function show(string $isletmeler_id)
    {
        $decryptedIsletmelerId = decrypt($isletmeler_id);

        $personeller = IsletmeYetkili::personeller($decryptedIsletmelerId);

        $data = [];

        foreach ($personeller as $personel) {
            $row = [];

            $personelinAitOlduguBirimler = KullaniciBirimUnvan::personelinBirimleri($personel->kullanicilar_id);

            $row[] = view('components.yonetim.kullanicilar.first-column', ['personel' => $personel])->render();
            $row[] = view('components.yonetim.kullanicilar.second-column', ['birimBilgileri' => $personelinAitOlduguBirimler])->render();
            $row[] = view('components.buttons.kullanicilar.duzenle-button', ['kullanicilar_id' => $personel->kullanicilar_id])->render();
            $row[] = view('components.buttons.kullanicilar.sil-button', ['kullanicilar_id' => $personel->kullanicilar_id])->render();

            $data[] = $row;
        }

        return response()->json([
            'data' => $data
        ], 200);
    }

    public function silmeModalGetir(Request $request)
    {
        $kullanicilar_id = decrypt($request->kullanicilar_id);
        $isletmeler_id   = decrypt($request->isletmeler_id);

        $kullanici = Kullanici::find($kullanicilar_id);

        $html = view('components.yonetim.kullanicilar.isletmeden-silme-modal-content', [
            'isletmeler_id'   => $isletmeler_id,
            'kullanici' => $kullanici
        ])->render();

        return response()->json([
            "success" => true,
            "html" => $html
        ], 200);
    }

    public function sil(Request $request)
    {
        $kullanicilar_id = decrypt($request->kullanicilar_id);
        $isletmeler_id   = decrypt($request->isletmeler_id);

        $kullanici = IsletmeYetkili::where('kullanicilar_id', $kullanicilar_id)
            ->where('isletmeler_id', $isletmeler_id)
            ->first();

        $isletmeBirimleri = "";

        $kullanici->update([
            'aktiflik' => 0
        ]);

        return response()->json([
            "success" => true,
            "message" => $kullanici
        ], 200);
    }

    public function girisForm()
    {
        return view('yonetim.giris');
    }

    public function girisYap(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->intended('yonetim');
        }
        return redirect()->back();
    }

    public function cikis(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('main.index');
    }
}

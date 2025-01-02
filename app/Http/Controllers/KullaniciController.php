<?php

namespace App\Http\Controllers;

use App\Models\Etkinlik;
use App\Models\EtkinlikIlDetaylari;
use App\Models\Il;
use App\Models\Isletme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class KullaniciController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('kullanici.index');
    }

    public function kamular(Request $request)
    {
        $kamular = Isletme::where('isletme_turleri_id', 1)->orderBy('baslik', 'asc')->paginate(20);

        if ($request->ajax()) {
            // İçeriği render edin
            $html = '';
            foreach ($kamular as $kamu) {
                $html .= view(
                    'components.kamu',
                    [
                        'text' => $kamu->baslik,
                        'href' => "/$kamu->kamular_id",
                        'logoUrl' => $kamu->logoUrl,
                        'websiteUrl' => $kamu->websiteUrl,
                        'xUrl' => $kamu->xUrl,
                        'instagramUrl' => $kamu->instagramUrl,
                        'linkedinUrl' => $kamu->linkedinUrl,
                    ]
                )->render();
            }

            // Paginator'ı render edin (Tailwind paginator'ınızı kullandığınız Blade dosyasını belirtin)
            $pagination = $kamular->links('pagination::tailwind')->render();

            return response()->json([
                'html' => $html,
                'pagination' => $pagination,
            ]);
        }

        return view('kullanici.kamular.index', compact(['kamular']));
    }

    public function etkinlikler()
    {
        $iller = Il::all();
        $etkinlikler = Etkinlik::orderBy('created_At', 'asc')->paginate(20);
        return view('kullanici.etkinlikler.index', compact('etkinlikler', 'iller'));
    }

    public function modalEkle()
    {
        $html = view('components.etkinlik-modal', [
            'modalBaslik' => 'Yeni Etkinlik Oluştur',
            'modalSubmitText' => 'Etkinlik oluştur',
            'kategori' => '',
            'isletme' => '',
            'etkinlikBaslik' => '',
            'aciklama' => '',
            'basvuruTarih' => '',
            'basvuruBitisTarih' => '',
            'baslamaTarih' => '',
            'bitisTarih' => '',
            'kapakResim' => '',
            'kontenjan' => '',
            'sehir' => '',
            'katilimSinirlama' => [],
            'postUrl' => url('kullanici/etkinlikler/'),
        ])->render();

        return response()->json([
            'html' =>  $html
        ]);
    }

    public function modalDuzenle(string $id)
    {
        $id = decrypt($id);
        $etkinlik = Etkinlik::find($id);
        $katilimSinirlama = EtkinlikIlDetaylari::where('etkinlikler_id', $id)->pluck('iller_id')->toArray();

        $html = view('components.etkinlik-modal', [
            'modalBaslik' => 'Etkinlik Düzenle',
            'modalSubmitText' => 'Etkinlik güncelle',
            'kategori' => $etkinlik->etkinlik_turleri_id,
            'isletme' => $etkinlik->isletmeler_id,
            'etkinlikBaslik' => $etkinlik->baslik,
            'aciklama' => $etkinlik->aciklama,
            'basvuruTarih' => $etkinlik->etkinlikBasvuruTarihi,
            'basvuruBitisTarih' => $etkinlik->etkinlikBasvuruBitisTarihi,
            'baslamaTarih' => $etkinlik->etkinlikBaslamaTarihi,
            'bitisTarih' => $etkinlik->etkinlikBitisTarihi,
            'kapakResim' => $etkinlik->kapakResmiYolu,
            'kontenjan' => $etkinlik->kontenjan,
            'sehir' => $etkinlik->iller_id,
            'katilimSinirlama' => $katilimSinirlama,
            'postUrl' => url('kullanici/etkinlikler').'/duzenle/'.encrypt($id),
        ])->render();

        return response()->json([
            'html' =>  $html
        ]);
    }

    public function girisForm()
    {
        return view('kullanici.giris');
    }

    public function girisYap(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->intended('kullanici');
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

<?php

namespace App\Http\Controllers;

use App\Models\Etkinlik;
use App\Models\EtkinlikIlDetaylari;
use App\Models\Isletme;
use App\Models\Resim;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class KullaniciController extends Controller
{
      /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('yonetim.index');
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
                        'text'         => $kamu->baslik,
                        'href'         => "/$kamu->kamular_id",
                        'logoUrl'      => $kamu->logoUrl,
                        'websiteUrl'   => $kamu->websiteUrl,
                        'xUrl'         => $kamu->xUrl,
                        'instagramUrl' => $kamu->instagramUrl,
                        'linkedinUrl'  => $kamu->linkedinUrl,
                    ]
                )->render();
            }

              // Paginator'ı render edin (Tailwind paginator'ınızı kullandığınız Blade dosyasını belirtin)
            $pagination = $kamular->links('pagination::tailwind')->render();

            return response()->json([
                'html'       => $html,
                'pagination' => $pagination,
            ]);
        }

        return view('yonetim.kamular.index', compact(['kamular']));
    }

      /**
     * Yeni etkinlik oluşturma modalını döndürür.
     *
     * @return JsonResponse
     */
    public function modalEkle(): JsonResponse
    {
          // Modalda doldurulması gereken varsayılan alanlar
        $data = [
            'modalBaslik'       => 'Yeni Etkinlik Oluştur',
            'modalSubmitText'   => 'Etkinlik oluştur',
            'kategori'          => '',
            'isletme'           => '',
            'etkinlikBaslik'    => '',
            'aciklama'          => '',
            'basvuruTarih'      => '',
            'basvuruBitisTarih' => '',
            'baslamaTarih'      => '',
            'bitisTarih'        => '',
            'kapakResim'        => '',
            'kontenjan'         => '',
            'sehir'             => '',
            'katilimSinirlama'  => [],
            'digerResimler'     => [],
            'yorumDurumu'       => '',
            'sosyalMedyaDurum'  => true,
            'postUrl'           => url('yonetim/etkinlikler/'),
        ];

          // Blade view'i render ederek HTML çıktısını yakalıyoruz.
        $html = view('components.etkinlik-modal', $data)->render();

          // JSON şeklinde döndürüyoruz.
        return response()->json([
            'html' => $html,
        ], 200);
    }

      /**
     * Var olan bir etkinliğin düzenlenmesi için modalı döndürür.
     *
     * @param  string  $id  Şifreli etkinlik ID'si
     * @return JsonResponse
     */
    public function modalDuzenle(string $id): JsonResponse
    {
          // Gelen ID'yi çözüyoruz
        $decryptedId = decrypt($id);

          // İlgili etkinliği veya bulunamazsa 404 döndürür
        $etkinlik = Etkinlik::findOrFail($decryptedId);

          // İllere göre katılım sınırlaması varsa onları çekiyoruz
        $katilimSinirlama = EtkinlikIlDetaylari::where('etkinlikler_id', $decryptedId)
            ->pluck('iller_id')
            ->toArray();

          // Etkinliğe ait diğer resimler varsa onları çekiyoruz
        $resimler = Resim::where('etkinlikler_id', $decryptedId)->pluck('resimYolu')->toArray();

          // Modalda doldurulması gereken veriler
        $data = [
            'modalBaslik'       => 'Etkinlik Düzenle',
            'modalSubmitText'   => 'Etkinlik güncelle',
            'kategori'          => $etkinlik->etkinlik_turleri_id,
            'isletme'           => $etkinlik->isletmeler_id,
            'etkinlikBaslik'    => $etkinlik->baslik,
            'aciklama'          => $etkinlik->aciklama,
            'basvuruTarih'      => $etkinlik->etkinlikBasvuruTarihi,
            'basvuruBitisTarih' => $etkinlik->etkinlikBasvuruBitisTarihi,
            'baslamaTarih'      => $etkinlik->etkinlikBaslamaTarihi,
            'bitisTarih'        => $etkinlik->etkinlikBitisTarihi,
            'kapakResim'        => $etkinlik->kapakResmiYolu,
            'kontenjan'         => $etkinlik->kontenjan,
            'sehir'             => $etkinlik->iller_id,
            'katilimSinirlama'  => $katilimSinirlama,
            'digerResimler'     => $resimler,
            'yorumDurumu'       => $etkinlik->yorumDurumu,
            'sosyalMedyaDurum'  => $etkinlik->sosyalMedyadaPaylas,
              // URL’yi dilerseniz route() kullanarak da oluşturabilirsiniz.
              // 'postUrl'         => route('kullanici.etkinlikler.update', encrypt($decryptedId)),
            'postUrl' => url('yonetim/etkinlikler/duzenle/' . encrypt($decryptedId)),
        ];

          // Blade view'i render ederek HTML çıktısını yakalıyoruz.
        $html = view('components.etkinlik-modal', $data)->render();

          // JSON şeklinde döndürüyoruz.
        return response()->json([
            'html' => $html,
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

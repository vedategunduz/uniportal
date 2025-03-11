<?php

namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
use App\Http\Requests\ZiyaretRequest;
use App\Mail\Ziyaret\ZiyaretEkibiMail;
use App\Mail\Ziyaret\ZiyaretTalebiMail;
use App\Models\Etkinlik;
use App\Models\Isletme;
use App\Models\Kullanici;
use App\Models\KullaniciBirimUnvan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ToplantiController extends Controller
{
    public function index()
    {
        return view('yonetim.toplanti.index');
    }

    public function show($etkinlik_id)
    {
        $etkinlik_id = decrypt($etkinlik_id);
        $etkinlik = Etkinlik::find($etkinlik_id);

        return view('yonetim.kampanya.detay', compact('etkinlik'));
    }

    public function create()
    {
        $etkinlik = null;

        $tum_isletmeler = Isletme::where('aktiflik', 1)->get();

        $html = view('yonetim.toplanti.ekle-modal', compact('etkinlik', 'tum_isletmeler'))->render();

        return response()->json([
            'success' => true,
            'html'    => $html
        ], 200);
    }

    public function store(ZiyaretRequest $request)
    {
        $validated = $request->validated();

        $validated['etkinlik_turleri_id']   = decrypt($validated['etkinlik_turleri_id']);
        $validated['isletmeler_id']         = decrypt($validated['isletmeler_id']);
        $validated['giden_isletmeler_id']   = decrypt($validated['giden_isletmeler_id']);
        $validated['gidilen_isletmeler_id'] = decrypt($validated['gidilen_isletmeler_id']);

        $validated['yorumDurumu']         = $request->has('yorumDurumu');
        $validated['sosyalMedyadaPaylas'] = $request->has('sosyalMedyadaPaylas');
        $validated['mailDurumu']          = $request->has('mailDurumu');
        $validated['kod']                 = uniqid();

        $etkinlik = Etkinlik::create($validated);

        $giden_idler = array_map('decrypt', $validated['gidenler_id']);
        $gidenler = Kullanici::whereIn('kullanicilar_id', $giden_idler)->get();

        $gidilen_idler = array_map('decrypt', $validated['davet_kullanicilar_id']);
        $gidilenler = Kullanici::whereIn('kullanicilar_id', $gidilen_idler)->get();

        $giden_isletme = Isletme::find($validated['giden_isletmeler_id']);
        $gidilen_isletme = Isletme::find($validated['gidilen_isletmeler_id']);

        foreach ($gidilenler as $kullanici) {
            try {
                Mail::to($kullanici->email)
                    ->send(
                        new ZiyaretTalebiMail(
                            $kullanici,
                            $giden_isletme,
                            $gidenler,
                            $etkinlik
                        )
                    );
            } catch (\Throwable $th) {
                //throw $th;
            }

            $etkinlik->katilimcilar()->attach($kullanici->kullanicilar_id, [
                'durum'                 => 'beklemede',
                'katilimciTipi'         => 'gidilen'
            ]);
        }

        foreach ($gidenler as $kullanici) {
            try {
                Mail::to($kullanici->email)
                    ->send(
                        new ZiyaretEkibiMail(
                            $etkinlik,
                            $kullanici,
                            $gidilen_isletme,
                            $gidilenler,
                            $gidenler,
                        )
                    );
            } catch (\Throwable $th) {
                //throw $th;
            }
            // Mail taslağı oluştur davet eden için
            $etkinlik->katilimcilar()->attach($kullanici->kullanicilar_id, [
                'durum'                 => 'beklemede',
                'katilimciTipi'         => 'giden'
            ]);
        }

        $attachments = $gidenler->pluck('kullanicilar_id')
            ->mapWithKeys(function ($id) {
                return [
                    $id => ['yoneticilikDurumu' => ($id == Auth::id()) ? 1 : 0]
                ];
            })->toArray();

        $etkinlik->mesajKanal->create([
            'baslik' => $etkinlik->baslik,
        ])->katilimcilar()->attach($attachments);

        return response()->json([
            'success' => true,
            'message' => 'Kampanya başarıyla oluşturuldu.'
        ], 200);
    }

    public function edit($etkinlik_id)
    {
        $etkinlik_id = decrypt($etkinlik_id);
        $etkinlik = Etkinlik::find($etkinlik_id);
        $tum_isletmeler = Isletme::where('aktiflik', 1)->get();

        $html = view('yonetim.toplanti.ekle-modal', compact('etkinlik', 'tum_isletmeler'))->render();

        return response()->json([
            'success' => true,
            'html'    => $html
        ], 200);
    }

    public function update(string $etkinlik_id, ZiyaretRequest $request)
    {
        $etkinlik_id = decrypt($etkinlik_id);
        $etkinlik = Etkinlik::find($etkinlik_id);

        $validated = $request->validated();

        $validated['etkinlik_turleri_id'] = decrypt($validated['etkinlik_turleri_id']);
        $validated['isletmeler_id'] = decrypt($validated['isletmeler_id']);

        $validated['yorumDurumu']         = $request->has('yorumDurumu');
        $validated['sosyalMedyadaPaylas'] = $request->has('sosyalMedyadaPaylas');
        $validated['mailDurumu']          = $request->has('mailDurumu');

        if ($request->file('kapakResmiYolu')) {
            $resim = $request->file('kapakResmiYolu');
            $folder = 'dosyalar/' . Auth::user()->anaIsletme->referans_kodu . '/' . Auth::user()->kod . '/etkinlik_dosyalari';
            $validated['kapakResmiYolu'] = uploadFile($resim, $folder);
        }

        if ($request->file('dosyalar')) {
            $dosyalar = $request->file('dosyalar');
            $folder = 'dosyalar/' . Auth::user()->anaIsletme->referans_kodu . '/' . Auth::user()->kod . '/etkinlik_dosyalari';

            foreach ($dosyalar as $dosya) {
                $dosya = uploadFile($dosya, $folder);
                $etkinlik->resimler()->create(['dosyaYolu' => $dosya]);
            }
        }

        $etkinlik->update($validated);
        $etkinlik->save();

        return response()->json([
            'success' => true,
            'message' => 'Kampanya başarıyla güncellendi.'
        ], 200);
    }

    public function destroy(string $etkinlik_id)
    {
        $etkinlik_id = decrypt($etkinlik_id);
        $etkinlik = Etkinlik::find($etkinlik_id);

        $etkinlik->aktiflik = 0;
        $etkinlik->save();

        return response()->json([
            'success' => true,
            'message' => 'Kampanya başarıyla silindi.'
        ], 200);
    }

    public function search(string $isletme_id, string $q, string $qNot = '')
    {
        $isletme_id = decrypt($isletme_id);

        $query = KullaniciBirimUnvan::query();

        // Sadece belirli işletmeye ait verileri çekmek için
        $query->where('isletmeler_id', $isletme_id);

        // Arama terimi üzerinden filtreleme
        $query->where(function ($query) use ($q) {
            $query->whereHas('birim', function ($query) use ($q) {
                // Burada 'baslik' sütunu, birim adını tutan sütun olarak örneklendirilmiştir.
                $query->where('baslik', 'like', '%' . $q . '%');
            })
                ->orWhereHas('unvan', function ($query) use ($q) {
                    // Unvan adının tutulduğu sütunu kendi veritabanınıza göre ayarlayın.
                    $query->where('baslik', 'like', '%' . $q . '%');
                })
                ->orWhereHas('kullanici', function ($query) use ($q) {
                    $query->where('ad', 'like', '%' . $q . '%')
                        ->orWhere('email', 'like', '%' . $q . '%')
                        ->orWhere('soyad', 'like', '%' . $q . '%');
                });
        })->take(10);

        $qNotArray = $qNot ? explode(',', $qNot) : [];
        if (!empty($qNotArray)) {
            $query->whereDoesntHave('kullanici', function ($query) use ($qNotArray) {
                $query->whereNotIn('email', $qNotArray);
            });
        }

        $kullanici_idleri = $query->pluck('kullanicilar_id');

        $kullanicilar = Kullanici::whereIn('kullanicilar_id', $kullanici_idleri)->get();

        $html = view('components.yonetim.toplanti.search-result', compact('kullanicilar'))->render();

        return response()->json([
            'success' => true,
            'html'    => $html
        ], 200);
    }


    public function katilimciListesi(string $etkinlik_id, string $type)
    {
        $etkinlik_id = decrypt($etkinlik_id);
        $etkinlik = Etkinlik::find($etkinlik_id);

        $gidenler = null;
        $gidilenler = null;

        if ($type == 'giden')
            $gidenler = $etkinlik->gidenKatilimcilar;
        else
            $gidilenler = $etkinlik->gidilenKatilimcilar;

        $html = view('yonetim.toplanti.partials.katilimci-listesi-modal', compact('gidenler', 'gidilenler'))->render();

        return response()->json([
            'success' => true,
            'html'    => $html
        ], 200);
    }

    public function dataTable(string $isletme_id)
    {
        $isletme_id = decrypt($isletme_id);

        $toplantilar = Etkinlik::where('isletmeler_id', $isletme_id)
            ->where('aktiflik', 1)
            ->where('etkinlik_turleri_id', 13)
            ->orderBy('etkinlikBaslamaTarihi', 'desc')
            ->get();

        $data = [];
        // Etkinlik verilerini satır haline getiriyoruz.
        // Tablo satırlarını birleştiriyoruz.
        foreach ($toplantilar as $etkinlik) {
            $gidenler = $etkinlik->gidenKatilimcilar;
            $gidilenler = $etkinlik->gidilenKatilimcilar;
            $row    = [];

            $row[]  = '<a class="!text-blue-500" target="_blank" href="#">' . $etkinlik->gidilenIsletme->baslik . '</a>';
            $row[]  = '<a title="' . $etkinlik->baslik . '" href="#">' . $etkinlik->baslik . '</a>';
            $row[]  = '<span class="text-xs text-nowrap">' . Carbon::parse($etkinlik->etkinlikBaslamaTarihi)->translatedFormat('d M, D Y - H:i') . '<br>' . Carbon::parse($etkinlik->etkinlikBitisTarihi)->translatedFormat('d M, D Y - H:i') . '</span>';
            $row[] = view('yonetim.toplanti.partials.katilimci-avatar', ['type' => 'giden', 'kullanicilar' => $gidenler, 'etkinlik_id' => $etkinlik->etkinlikler_id])->render();
            $row[] = view('yonetim.toplanti.partials.katilimci-avatar', ['type' => 'gidilen', 'kullanicilar' => $gidilenler, 'etkinlik_id' => $etkinlik->etkinlikler_id])->render();
            $row[]  = '
            <div class="flex items-stretch">
            <a href="javascript:void(0)" class="ziyaret-sohbet-baslat inline-flex items-center gap-2 p-2 bg-green-400 text-xs !text-white rounded rounded-r-none text-nowrap" data-id="' . encrypt($etkinlik->etkinlikler_id) . '" data-name="' . $etkinlik->baslik . '"><span>Sohbet başlat</span></a>
            <a href="javascript:void(0)" class="ziyaret-kanallar inline-flex items-center gap-2 p-2 bg-green-300 text-xs !text-white rounded rounded-l-none" data-name="' . $etkinlik->kod . '"><span>' . $etkinlik->mesajKanallari->count() . '</span><i class="bi bi-chat-dots-fill"></i></a>
            </div>';
            $row[]  = '<a href="javascript:void(0)" class="inline-flex p-2 bg-orange-400 text-xs !text-white rounded ziyaret-duzenle-modal open-modal" data-id="' . encrypt($etkinlik->etkinlikler_id) . '" data-modal="etkinlik-modal"><i class="bi bi-pencil-square"></i></a>';
            $row[]  = '<a href="javascript:void(0)" class="inline-flex p-2 bg-gs-red text-xs !text-white rounded ziyaret-sil" data-id="' . encrypt($etkinlik->etkinlikler_id) . '"><i class="bi bi-trash3"></i></a>';

            $data[] = $row;
        }
        // Tablo gövdesini gönderiyoruz.
        return response()->json([
            'success' => true,
            'data'    => $data
        ], 200);
    }
}

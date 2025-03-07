<?php

namespace App\Http\Controllers\Yonetim;

use App\Http\Controllers\Controller;
use App\Http\Requests\KampanyaRequest;
use App\Models\Dosya;
use App\Models\Etkinlik;
use Illuminate\Support\Facades\Auth;

class KampanyaController extends Controller
{
    public function index()
    {
        return view('yonetim.kampanya.index');
    }

    public function show($etkinlik_id)
    {
        $etkinlik_id = decrypt($etkinlik_id);
        $etkinlik = Etkinlik::find($etkinlik_id);

        return view('yonetim.kampanya.detay', compact('etkinlik'));
    }

    public function create()
    {
        return view('yonetim.kampanya.ekle');
    }

    public function store(KampanyaRequest $request)
    {
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

        $etkinlik = Etkinlik::create($validated);

        $dosyalar = Dosya::where('islem_yapan_id', Auth::id())->get();
        $dosyalar->each->delete();

        $etkinlik->resimler()->createMany($dosyalar->toArray());

        return redirect()->route('yonetim.kampanya.detay', compact('etkinlik'))->with('success', 'Kampanya başarıyla eklendi.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Paylasim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KullaniciPaylasimController extends Controller
{
    public function show($paylasim_id)
    {
        $paylasim_id = decrypt($paylasim_id);
        $paylasim = Paylasim::find($paylasim_id);

        if (!$paylasim) {
            return response()->json([
                'success' => false,
                'message' => 'Paylaşım bulunamadı.',
            ], 404);
        }

        $kullanici = $paylasim->kullanici;

        $html = view('yonetim.profil.paylasim-detay-modal', compact('paylasim', 'kullanici'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->all();

        if ($request->file('kapakFotoUrl')) {
            $file = $request->file('kapakFotoUrl');
            $folder = "image/paylasimlar" . Auth::user()->kod;
            $validated['kapakFotoUrl'] = uploadFile($file, $folder);
        }

        $paylasim = Auth::user()->paylasimlar()->create($validated);

        return response()->json([
            'success' => true,
            'message' => 'Paylaşım başarıyla oluşturuldu.',
            'id' => encrypt($paylasim->paylasimlar_id),
        ], 201);
    }

    public function destroy($paylasim_id)
    {
        $paylasim_id = decrypt($paylasim_id);
        $paylasim = Auth::user()->paylasimlar()->find($paylasim_id);

        if (!$paylasim) {
            return response()->json([
                'success' => false,
                'message' => 'Paylaşım bulunamadı.',
            ], 404);
        }

        $paylasim->aktiflik = 0;
        $paylasim->save();

        return response()->json([
            'success' => true,
            'message' => 'Paylaşım başarıyla silindi',
        ], 200);
    }

    public function begenToggle($paylasim_id)
    {
        $id = decrypt($paylasim_id);
        $paylasim = Auth::user()->paylasimlar()->findOrFail($id);
        $paylasim->begenToggle();

        return response()->json([
            'success' => true,
            'begeni' => $paylasim->begeniler->count(),
        ]);
    }

}

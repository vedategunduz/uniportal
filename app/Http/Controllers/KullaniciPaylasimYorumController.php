<?php

namespace App\Http\Controllers;

use App\Models\Paylasim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KullaniciPaylasimYorumController extends Controller
{
    public function store($paylasim_id, Request $request)
    {
        $validated = $request->all();

        $paylasim_id = decrypt($paylasim_id);

        $paylasim = Paylasim::find($paylasim_id);

        if (!$paylasim->yorumDurumu) {
            return response()->json([
                'success' => false,
                'message' => 'Bu paylasim için yorum yapılamaz.'
            ]);
        }

        if (!empty($validated['paylasim_yorumlari_id'])) {
            $yorum = $paylasim->yorumlar()->find(decrypt($validated['paylasim_yorumlari_id']));
            $yorum->yanitlar()->create([
                'kullanicilar_id' => Auth::id(),
                'paylasimler_id' => $paylasim_id,
                'yorum' => $validated['yorum'],
                'yorum_tipi' => $validated['yorum_tipi']
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Yorumunuz başarıyla eklendi.',
                'yorum' => $yorum,
                'tip' => 'yanit'
            ]);
        }

        $yorum = $paylasim->yorumlar()->create([
            'kullanicilar_id' => Auth::id(),
            'yorum' => $validated['yorum'],
        ]);

        Auth::user()->puanKullan(5);

        return response()->json([
            'success' => true,
            'message' => 'Yorumunuz başarıyla eklendi.',
            'yorum' => $yorum,
            'tip' => 'yorum'
        ]);
    }

    public function begenToggle($paylasim_id, $yorum_id)
    {
        $paylasim_id = decrypt($paylasim_id);
        $yorum_id = decrypt($yorum_id);

        $yorum = Paylasim::find($paylasim_id)->yorumlar()->find($yorum_id);

        $yorum->begenToggle();

        return response()->json([
            'success' => true,
            'begeni' => $yorum->begeniler()->count()
        ]);
    }
}

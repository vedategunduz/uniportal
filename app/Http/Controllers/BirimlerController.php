<?php

namespace App\Http\Controllers;

use App\Models\IsletmeBirim;
use App\Models\IsletmeYetkili;
use App\Models\KullaniciBirimUnvan;
use Illuminate\Http\Request;
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

    public function change(Request $request)
    {
        try {
            KullaniciBirimUnvan::findOrFail(decrypt($request->kullanici_birim_unvan_iliskileri_id))
                ->update([
                    'isletme_birimleri_id' => decrypt($request->isletme_birimleri_id)
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Kullanıcı\'nın birimi değiştirildi.'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error'   => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function birimSil(string $id)
    {
        try {
            IsletmeBirim::findOrFail($id)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Birim kaldırıldı.'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error'   => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy(string $id)
    {
        $decryptedId = decrypt($id);
        try {
            KullaniciBirimUnvan::findOrFail($decryptedId)->delete();

            return response()->json([
                'success' => true,
                'message' => 'Kullanıcı birimden kaldırıldı.'
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'error'   => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}

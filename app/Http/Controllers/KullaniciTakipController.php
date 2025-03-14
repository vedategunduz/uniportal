<?php

namespace App\Http\Controllers;

use App\Models\Kullanici;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KullaniciTakipController extends Controller
{
    public function store($kullanici)
    {
        $kullanici->takipciler()->attach(Auth::id());

        return response()->json(['success' => true, 'message' => 'Kullanıcı takip edildi.', 'count' => $kullanici->takipciler()->count()]);
    }

    public function destroy($kullanici)
    {
        $kullanici->takipciler()->detach(Auth::id());

        return response()->json(['success' => true, 'message' => 'Kullanıcı takipten çıkarıldı.', 'count' => $kullanici->takipciler()->count()]);
    }

    public function toggle($kullanici_id)
    {
        $kullanici_id = decrypt($kullanici_id);

        $kullanici = Kullanici::find($kullanici_id);

        if ($kullanici->takipciler()->where('takip_eden_id', Auth::id())->exists()) {

            return $this->destroy($kullanici);
        } else {

            return $this->store($kullanici);
        }
    }
}

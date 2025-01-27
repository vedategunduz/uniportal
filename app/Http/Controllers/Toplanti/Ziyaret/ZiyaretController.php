<?php

namespace App\Http\Controllers\Toplanti\Ziyaret;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Isletme;
use App\Models\IsletmeYetkili;
use App\Models\Kullanici;

class ZiyaretController extends Controller
{
    public function ziyaretTalepModalGetir()
    {
        $isletmeler = IsletmeYetkili::aitOldugumIsletmeleriGetir();

        $tumIsletmeler = Isletme::all();

        $isletmeler = Isletme::select('isletmeler_id', 'baslik')->whereIn('isletmeler_id', $isletmeler)->get();

        $html = view(
            'components.yonetim.toplantilar.ziyaret.modal',
            [
                'isletmeler'    => $isletmeler,
                'tumIsletmeler' => $tumIsletmeler
            ]
        )->render();

        return response()->json([
            'success' => true,
            'html'    => $html
        ]);
    }

    public function personeller(Request $request)
    {
        // Şifrelenmiş veriyi çözüyoruz
        $decrypted_isletmeler_id = decrypt($request->isletmeler_id);

        // İlgili işletmenin yetkilisi/kullanıcılarının ID'lerini pluck ile alıyoruz
        $kullanici_ids = IsletmeYetkili::where('isletmeler_id', $decrypted_isletmeler_id)
            ->whereNot('kullanicilar_id', 1)
            ->pluck('kullanicilar_id');

        // Arama parametresi
        $search = $request->search;

        $personellerQuery = Kullanici::whereIn('kullanicilar_id', $kullanici_ids);

        // Eğer bir arama değeri varsa sorguya ekliyoruz
        if (!empty($search)) {
            $personellerQuery->where(function ($query) use ($search) {
                $query->where('ad', 'like', '%' . $search . '%')
                    ->orWhere('soyad', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        // Sorguyu çalıştırıp sonuçları alıyoruz
        $personeller = $personellerQuery->get();

        // View'ı render ediyoruz
        $html = view(
            'components.yonetim.toplantilar.ziyaret.personeller',
            [
                'personeller' => $personeller
            ]
        )->render();

        // JSON döndürüyoruz
        return response()->json([
            'success' => true,
            'html'    => $html
        ]);
    }

    public function personelCard(Request $request)
    {
        $decryptedId = decrypt($request->kullanicilar_id);
        $kullanici = Kullanici::find($decryptedId);

        $html = view(
            'components.yonetim.toplantilar.ziyaret.personel-card',
            [
                'kullanici' => $kullanici
            ]
        )->render();

        return response()->json([
            'success' => true,
            'html'    => $html,
            'email'   => $kullanici->email
        ]);
    }
}

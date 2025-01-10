<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Model;

class IsletmeBirim extends Model
{
    use IslemYapanTrait;

    protected $table = "isletme_birimleri";

    protected $primaryKey = "isletme_birimleri_id";

    protected $fillabel = [
        'isletmeler_id',
        'birim_tipleri_id',
        'baslik',
    ];

    public function isletmeBirimTipi()
    {
        return $this->belongsTo(BirimTip::class, 'birim_tipleri_id', 'birim_tipleri_id');
    }

    public static function isletmeBirimPersonelBul($isletme_birimleri_id)
    {
        $birimPersonelleri = KullaniciBirimUnvan::with('kullanici', 'unvan')
            ->where('isletme_birimleri_id', $isletme_birimleri_id)
            ->get()
            ->sortBy(function ($item) {
                return $item->unvan->unvanSira;
            });

        return $birimPersonelleri;
    }

    public static function isletmeBirimleriGetir($isletmeler_id)
    {
        return IsletmeBirim::with('isletmeBirimTipi')->whereIn('isletmeler_id', $isletmeler_id)
            ->where('aktiflik', 1)
            ->orderBy('baslik', 'asc')
            ->get();
    }

    public static function isletmeBirimSil($isletme_birimleri_id)
    {
        $isletmeBirim = IsletmeBirim::find($isletme_birimleri_id);
        $isletmeBirim->aktiflik = 0;
        $isletmeBirim->save();

        KullaniciBirimUnvan::where('isletme_birimleri_id', $isletme_birimleri_id)->delete();
    }
}

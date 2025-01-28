<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Model;

class KullaniciBirimUnvan extends Model
{
    use IslemYapanTrait;

    protected $table = 'kullanici_birim_unvan_iliskileri';

    protected $primaryKey = 'kullanici_birim_unvan_iliskileri_id';

    protected $fillable = [
        'kullanicilar_id',
        'isletme_birimleri_id',
        'unvanlar_id',
        'aktiflik'
    ];

    public function kullanici()
    {
        return $this->belongsTo(Kullanici::class, 'kullanicilar_id', 'kullanicilar_id');
    }

    public function IzinliKullanici()
    {
        return $this
            ->belongsTo(Kullanici::class, 'kullanicilar_id', 'kullanicilar_id')
            ->where('veriGosterimIzni', 1)
            ->where('aktiflik', 1)
            ->orderBy('ad', 'asc');
    }

    public function unvan()
    {
        return $this->belongsTo(Unvan::class, 'unvanlar_id', 'unvanlar_id')->where('aktiflik', 1);
    }

    public function birim()
    {
        return $this->belongsTo(IsletmeBirim::class, 'isletme_birimleri_id', 'isletme_birimleri_id')->where('aktiflik', 1);
    }

    public static function personelinBirimleri($kullanicilar_id)
    {
        return self::with('unvan', 'birim')
            ->where('kullanicilar_id', $kullanicilar_id)
            ->get();
    }

    /**
     * =================== Düzenle bu fonksiyonu ===================
     * @param string $birimler_id
     */
    public static function birimiOlmayanKullanicilar()
    {
        return self::rightJoin(
            'isletme_yetkilileri',
            'isletme_yetkilileri.kullanicilar_id',
            '=',
            'kullanici_birim_unvan_iliskileri.kullanicilar_id'
        )
            ->whereNull('kullanici_birim_unvan_iliskileri.kullanicilar_id')
            ->where('isletme_yetkilileri.isletmeler_id', 143)
            ->where('isletme_yetkilileri.aktiflik', 1)
            ->whereNot('isletme_yetkilileri.kullanicilar_id', 1)
            ->get();
    }
    // =================== Düzenle bu fonksiyonu ===================
    public static function birimeYerlesmemisPersonelSayisi()
    {
        return self::birimiOlmayanKullanicilar()->pluck('kullanicilar_id')->count();
    }
}

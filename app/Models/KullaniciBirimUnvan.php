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
    ];

    public function kullanici()
    {
        return $this->belongsTo(Kullanici::class, 'kullanicilar_id', 'kullanicilar_id');
    }

    public function unvan()
    {
        return $this->belongsTo(Unvan::class, 'unvanlar_id', 'unvanlar_id');
    }

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
            ->get();
    }

    public static function oBirimeAitOlmayanIsletmeKullanicilari($birimler_id)
    {
    }

    public static function birimeYerlesmemisPersonelSayisi()
    {
        return self::birimiOlmayanKullanicilar()->pluck('kullanicilar_id')->count();
    }
}

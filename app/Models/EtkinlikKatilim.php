<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtkinlikKatilim extends Model
{
    /** @use HasFactory<\Database\Factories\EtkinlikKatilimFactory> */
    use HasFactory, IslemYapanTrait;

    protected $table = 'etkinlik_katilimlari';

    protected $primaryKey = 'etkinlik_katilimlari_id';

    protected $fillable = [
        'etkinlikler_id',
        'kullanicilar_id',
        'aciklama',
        'durum',
        'katilimciTipi'
    ];

    public function kullanici()
    {
        return $this->belongsTo(Kullanici::class, 'kullanicilar_id', 'kullanicilar_id');
    }

    public function etkinlik()
    {
        return $this->belongsTo(Etkinlik::class, 'etkinlikler_id', 'etkinlikler_id');
    }

    public function giden() {
        return $this->where('katilimciTipi', 'giden');
    }

    public function davetli() {
        return $this->where('katilimciTipi', 'davetli');
    }

    public function katilimci() {
        return $this->where('katilimciTipi', 'katilimci');
    }

    // public function bilgi()
    // {
    //     return $this->belongsTo(Kullanici::class, 'kullanicilar_id', 'kullanicilar_id');
    // }

    // public function gidilenIsletme()
    // {
    //     return $this->belongsTo(Isletme::class, 'gidilen_isletmeler_id', 'isletmeler_id');
    // }

    // public function gidenIsletme()
    // {
    //     return $this->belongsTo(Isletme::class, 'giden_isletmeler_id', 'isletmeler_id');
    // }

    // public static function katilimcilar($etkinlik_id, $type)
    // {
    //     return self::with('bilgi')->where('etkinlikler_id', $etkinlik_id)->where('katilimciTipi', $type)->get();
    // }

    // public static function ziyaretIsletmeler($etkinlik_id)
    // {
    //     return self::select('giden_isletmeler_id', 'gidilen_isletmeler_id')->where('etkinlikler_id', $etkinlik_id)->first();
    // }
}

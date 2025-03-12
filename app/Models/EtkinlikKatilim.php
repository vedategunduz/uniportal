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
}

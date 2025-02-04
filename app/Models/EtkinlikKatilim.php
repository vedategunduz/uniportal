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
        'giden_isletmeler_id',
        'gidilen_isletmeler_id',
        'durum',
        'katilimciTipi'
    ];

    public function bilgi()
    {
        return $this->belongsTo(Kullanici::class, 'kullanicilar_id', 'kullanicilar_id');
    }

    public function gidilenIsletme()
    {
        return $this->belongsTo(Isletme::class, 'gidilen_isletmeler_id', 'isletmeler_id');
    }

    public function gidenIsletme()
    {
        return $this->belongsTo(Isletme::class, 'giden_isletmeler_id', 'isletmeler_id');
    }

    public function gidenKullanicilar()
    {
        return $this->hasMany(EtkinlikKatilim::class, 'giden_isletmeler_id', 'giden_isletmeler_id')
            ->where('katilimciTipi', 'giden');
    }

    public function gidilenKullanicilar()
    {
        return $this->hasMany(EtkinlikKatilim::class, 'giden_isletmeler_id', 'giden_isletmeler_id')
            ->where('katilimciTipi', 'davetli');
    }
}

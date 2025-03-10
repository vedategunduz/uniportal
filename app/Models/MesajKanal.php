<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class MesajKanal extends Model
{
    use IslemYapanTrait;

    protected $table = 'mesaj_kanallari';

    protected $primaryKey = 'mesaj_kanallari_id';

    protected $fillable = [
        'etkinlikler_id',
        'baslik',
        'resim',
        'tur',
        'aktiflik',
        'sadeceYonetici',
    ];

    public function etkinlik()
    {
        return $this->belongsTo(Etkinlik::class, 'etkinlikler_id', 'etkinlikler_id');
    }

    public function mesajlar()
    {
        return $this->hasMany(Mesaj::class, 'mesaj_kanallari_id', 'mesaj_kanallari_id');
    }

    public function katilimcilar()
    {
        return $this->hasMany(MesajKanalKatilimci::class, 'mesaj_kanallari_id', 'mesaj_kanallari_id');
    }

    public function aktifKatilimcilar()
    {
        return $this->hasMany(MesajKanalKatilimci::class, 'mesaj_kanallari_id', 'mesaj_kanallari_id')
            ->where('aktiflik', 1);
    }
}

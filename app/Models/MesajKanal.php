<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Model;

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

    public function mesajlar() {
        return $this->hasMany(Mesaj::class, 'mesaj_kanallari_id', 'mesaj_kanallari_id');
    }

    public function katilimcilar() {
        return $this->hasMany(MesajKanalKatilimci::class, 'mesaj_kanallari_id', 'mesaj_kanallari_id');
    }
}

<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Model;

class EtkinlikYorum extends Model
{
    use IslemYapanTrait;

    protected $table = 'etkinlik_yorumlari';

    protected $primaryKey = 'etkinlik_yorumlari_id';

    protected $fillable = [
        'etkinlikler_id',
        'kullanicilar_id',
        'yorum',
        'aktiflik'
    ];

    public function detay() {
        return $this->hasMany(EtkinlikYorumBegeniDetay::class, 'etkinlik_yorumlari_id', 'etkinlik_yorumlari_id');
    }
}

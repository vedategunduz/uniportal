<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Model;

class EtkinlikBegeniDetay extends Model
{
    use IslemYapanTrait;

    protected $table = 'etkinlik_begeni_detaylari';

    protected $primaryKey = 'etkinlik_begeni_detaylari_id';

    protected $fillable = [
        'etkinlikler_id',
        'kullanicilar_id',
        'aktiflik',
    ];
}

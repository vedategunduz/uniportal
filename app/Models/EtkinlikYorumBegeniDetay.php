<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Model;

class EtkinlikYorumBegeniDetay extends Model
{
    use IslemYapanTrait;

    protected $table = 'etkinlik_yorum_begeni_detaylari';

    protected $primaryKey = 'etkinlik_yorum_begeni_detaylari_id';

    protected $fillable = [
        'etkinlik_yorumlari_id',
        'kullanicilar_id',
    ];
}

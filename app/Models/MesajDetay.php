<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MesajDetay extends Model
{
    use IslemYapanTrait;

    protected $table = 'mesaj_detaylari';

    protected $primaryKey = 'mesaj_detaylari_id';

    protected $fillable = [
        'mesajlar_id',
        'emoji_tipleri_id',
        'kullanicilar_id',
        'aktiflik',
    ];

    public function kullanici()
    {
        return $this->belongsTo(Kullanici::class, 'kullanicilar_id', 'kullanicilar_id');
    }

    public function emoji()
    {
        return $this->belongsTo(EmojiTip::class, 'emoji_tipleri_id', 'emoji_tipleri_id');
    }
}

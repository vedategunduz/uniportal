<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Model;

class MesajKanalKatilimci extends Model
{
    use IslemYapanTrait;

    protected $table = 'mesaj_kanal_katilimcilari';

    protected $primaryKey = 'mesaj_kanal_katilimcilari_id';

    protected $fillable = [
        'mesaj_kanallari_id',
        'kullanicilar_id',
    ];

    public function kullanici() {
        return $this->belongsTo(Kullanici::class, 'kullanicilar_id', 'kullanicilar_id');
    }
}

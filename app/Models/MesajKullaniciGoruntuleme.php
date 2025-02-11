<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Model;

class MesajKullaniciGoruntuleme extends Model
{
    use IslemYapanTrait;

    protected $table = 'mesaj_kullanici_goruntuleme';

    protected $primaryKey = 'mesaj_kullanici_goruntuleme_id';

    protected $fillable = [
        'mesajlar_id',
        'kullanicilar_id',
        'mesaj_kanallari_id',
    ];
}

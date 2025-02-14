<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Mesaj extends Model
{
    use IslemYapanTrait;

    protected $table = 'mesajlar';

    protected $primaryKey = 'mesajlar_id';

    protected $fillable = [
        'mesaj_kanallari_id',
        'kullanicilar_id',
        'alintilanan_mesajlar_id',
        'isletmeler_id',
        'unvanlar_id',
        'mesaj',
        'dosya',
        'aktiflik',
    ];

    public function alinti()
    {
        return $this->belongsTo(Mesaj::class, 'alintilanan_mesajlar_id', 'mesajlar_id');
    }

    public function kanal()
    {
        return $this->belongsTo(MesajKanal::class, 'mesaj_kanallari_id', 'mesaj_kanallari_id');
    }

    public function kullanici()
    {
        return $this->belongsTo(Kullanici::class, 'kullanicilar_id', 'kullanicilar_id');
    }

    public function unvan()
    {
        return $this->belongsTo(Unvan::class, 'unvanlar_id', 'unvanlar_id');
    }

    public function isletme()
    {
        return $this->belongsTo(Isletme::class, 'isletmeler_id', 'isletmeler_id');
    }

    public function detay()
    {
        return $this->hasMany(MesajDetay::class, 'mesajlar_id', 'mesajlar_id');
    }
}

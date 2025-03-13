<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class EtkinlikYorum extends Model
{
    use IslemYapanTrait;

    protected $table = 'etkinlik_yorumlari';

    protected $primaryKey = 'etkinlik_yorumlari_id';

    protected $fillable = [
        'etkinlikler_id',
        'kullanicilar_id',
        'yanitlanan_etkinlik_yorumlari_id',
        'yorum',
        'yorum_tipi',
        'aktiflik'
    ];

    public function begeni() {
        return $this->hasMany(EtkinlikYorumBegeniDetay::class, 'etkinlik_yorumlari_id', 'etkinlik_yorumlari_id');
    }

    public function kullanici()
    {
        return $this->belongsTo(Kullanici::class, 'kullanicilar_id', 'kullanicilar_id');
    }

    public function yanit() {
        return $this->hasMany(EtkinlikYorum::class, 'yanitlanan_etkinlik_yorumlari_id', 'etkinlik_yorumlari_id')->where('aktiflik', 1);
    }

    public function begenToggle() {
        $begeni = $this->begeni()->where('kullanicilar_id', Auth::id())->first();
        $kullanici = $this->kullanici;

        if ($begeni) {
            Auth::user()->setUnipoint(-1);
            $kullanici->setUnipoint(-1);

            $begeni->delete();
        } else {
            Auth::user()->setUnipoint(1);
            $kullanici->setUnipoint(1);

            $this->begeni()->create([
                'kullanicilar_id' => Auth::id()
            ]);
        }
    }
}

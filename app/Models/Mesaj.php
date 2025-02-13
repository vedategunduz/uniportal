<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mesaj extends Model
{
    protected $table = 'mesajlar';

    protected $primaryKey = 'mesajlar_id';

    protected $fillable = [
        'mesaj_kanallari_id',
        'kullanicilar_id',
        'alintilanan_mesajlar_id',
        'mesaj',
        'dosya',
        'aktiflik',
    ];

    public function alinti() {
        return $this->belongsTo(Mesaj::class, 'alintilanan_mesajlar_id', 'mesajlar_id');
    }

    public function kanal() {
        return $this->belongsTo(MesajKanal::class, 'mesaj_kanallari_id', 'mesaj_kanallari_id');
    }

    public function kullanici() {
        return $this->belongsTo(Kullanici::class, 'kullanicilar_id', 'kullanicilar_id');
    }
}

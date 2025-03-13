<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Isletme extends Model
{
    use HasFactory, IslemYapanTrait;

    protected $table = 'isletmeler';

    protected $primaryKey = 'isletmeler_id';

    protected $fillable = [
        'isletme_turleri_id',
        'iller_id',
        'referans_kodu',
        'referans',
        'baslik',
        'adres',
        'kisaltma',
        'mailUzanti',
        'vectorelLogoUrl',
        'logoUrl',
        'websiteUrl',
        'xUrl',
        'instagramUrl',
        'linkedinUrl',
        'digerUrl',
        'aktiflik',
    ];

    public function personeller()
    {
        return $this->hasMany(KullaniciBirimUnvan::class, 'isletmeler_id', 'isletmeler_id')->whereNot('kullanicilar_id', 1);
    }

    public static function isletmelerimiGetir()
    {
        $isletmeler = IsletmeYetkili::aitOldugumIsletmeleriGetir();
        return Isletme::whereIn('isletmeler_id', $isletmeler)->orderBy('baslik', 'asc')->get();
    }

    public function tur()
    {
        return $this->belongsTo(IsletmeTur::class, 'isletme_turleri_id', 'isletme_turleri_id');
    }
}

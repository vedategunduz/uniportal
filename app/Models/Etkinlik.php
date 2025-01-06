<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etkinlik extends Model
{
    /** @use HasFactory<\Database\Factories\EtkinlikFactory> */
    use HasFactory, IslemYapanTrait;

    protected $table = 'etkinlikler';

    protected $primaryKey = 'etkinlikler_id';

    protected $fillable = [
        'etkinlik_turleri_id',
        'isletmeler_id',
        'iller_id',
        'etkinlikBasvuruTarihi',
        'etkinlikBasvuruBitisTarihi',
        'etkinlikBaslamaTarihi',
        'etkinlikBitisTarihi',
        'kapakResmiYolu',
        'baslik',
        'aciklama',
        'kontenjan',
        'yorumDurumu',
        'sosyalMedyadaPaylas'
    ];

    public function isletme() {
        return $this->belongsTo(Isletme::class, 'isletmeler_id', 'isletmeler_id');
    }

    public function il() {
        return $this->belongsTo(Il::class, 'iller_id', 'iller_id');
    }

    public function etkinlikTuru() {
        return $this->belongsTo(EtkinlikTur::class, 'etkinlik_turleri_id', 'etkinlik_turleri_id');
    }

    public function etkinlikIlDetayi() {
        return $this->hasMany(EtkinlikIlDetaylari::class, 'etkinlikler_id', 'etkinlikler_id');
    }
}

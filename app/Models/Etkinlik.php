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
        'sosyalMedyadaPaylas',
        'aktiflik',
    ];

    public function etkinlikKatilim()
    {
        return $this->belongsTo(EtkinlikKatilim::class, 'etkinlikler_id', 'etkinlikler_id');
    }

    public function katilimcilar()
    {
        return $this->belongsToMany(
            Kullanici::class,
            'etkinlik_katilimlari',
            'etkinlikler_id',
            'kullanicilar_id'
        );
    }

    public static function ekle($validatedData)
    {
        $validatedData['iller_id']            = decrypt($validatedData['iller_id']);
        $validatedData['isletmeler_id']       = decrypt($validatedData['isletmeler_id']);
        $validatedData['etkinlik_turleri_id'] = decrypt($validatedData['etkinlik_turleri_id']);

        return self::create($validatedData);
    }

    // public function galeri()
    // {
    //     return $this->hasMany(Resim::class, 'etkinlikler_id', 'etkinlikler_id');
    // }
}

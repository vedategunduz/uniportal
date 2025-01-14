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

    public static function ekle($validatedData)
    {
        $validatedData['iller_id']            = decrypt($validatedData['iller_id']);
        $validatedData['isletmeler_id']       = decrypt($validatedData['isletmeler_id']);
        $validatedData['etkinlik_turleri_id'] = decrypt($validatedData['etkinlik_turleri_id']);

        return self::create($validatedData);
    }


    // public function isletme()
    // {
    //     return $this->belongsTo(Isletme::class, 'isletmeler_id', 'isletmeler_id');
    // }

    // public function il()
    // {
    //     return $this->belongsTo(Il::class, 'iller_id', 'iller_id');
    // }

    // public function etkinlikTuru()
    // {
    //     return $this->belongsTo(EtkinlikTur::class, 'etkinlik_turleri_id', 'etkinlik_turleri_id');
    // }

    // public function etkinlikIlDetayi()
    // {
    //     return $this->hasMany(EtkinlikIlDetaylari::class, 'etkinlikler_id', 'etkinlikler_id');
    // }
    // MODEL
    // public static function etkinlikUpdate(array $veriler)
    // {
    //     $etkinlik = self::find($veriler['etkinlikler_id']);
    //     if ($etkinlik) {
    //         $etkinlik->update(
    //             [
    //                 'baslik'                     => $veriler['etkinlikBaslik'],
    //                 'aciklama'                   => $veriler['etkinlikAciklama'],
    //                 'etkinlik_turleri_id'        => $veriler['etkinlik_turleri_id'],
    //                 'isletmeler_id'              => $veriler['isletmeler_id'],
    //                 'iller_id'                   => $veriler['iller_id'],
    //                 'kontenjan'                  => $veriler['etkinlikKontenjan'],
    //                 'etkinlikBasvuruTarihi'      => $veriler['etkinlikBasvuru'],
    //                 'etkinlikBasvuruBitisTarihi' => $veriler['etkinlikBasvuruBitis'],
    //                 'etkinlikBaslamaTarihi'      => $veriler['etkinlikBaslangic'],
    //                 'etkinlikBitisTarihi'        => $veriler['etkinlikBitis'],
    //                 'sosyalMedyadaPaylas'        => $veriler['sosyalMedyadaPaylas'],
    //                 'yorumDurumu'                => $veriler['yorumDurumu'],
    //                 'kapakResmiYolu'             => $veriler['etkinlikKapakResmi']
    //             ]
    //         );
    //     }
    //     return $etkinlik;
    // }
}

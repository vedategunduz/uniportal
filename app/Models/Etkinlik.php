<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
        'katilimSarti',
        'kontenjan',
        'yorumDurumu',
        'sosyalMedyadaPaylas',
        'aktiflik',
    ];

    public function tur()
    {
        return $this->belongsTo(EtkinlikTur::class, 'etkinlik_turleri_id', 'etkinlik_turleri_id');
    }

    public function isletme()
    {
        return $this->belongsTo(Isletme::class, 'isletmeler_id', 'isletmeler_id');
    }

    public function begeni()
    {
        return $this->hasMany(EtkinlikBegeniDetay::class, 'etkinlikler_id', 'etkinlikler_id');
    }

    public function yorum()
    {
        return $this->hasMany(EtkinlikYorum::class, 'etkinlikler_id', 'etkinlikler_id')->where('aktiflik', 1);
    }

    public function resimler() {
        return $this->hasMany(EtkinlikDosya::class, 'etkinlikler_id', 'etkinlikler_id');
    }

    public function il ()
    {
        return $this->belongsTo(Il::class, 'iller_id', 'iller_id');
    }

    public function begeniToggle()
    {
        $begeni = $this->begeni()->where('kullanicilar_id', Auth::id())->first();

        if ($begeni) {
            $begeni->delete();
        } else {
            $this->begeni()->create([
                'kullanicilar_id' => Auth::id(),
            ]);
        }
    }

    public function etkinlikKatilim()
    {
        return $this->hasMany(EtkinlikKatilim::class, 'etkinlikler_id', 'etkinlikler_id');
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

    public function mesajKanal()
    {
        return $this->belongsTo(MesajKanal::class, 'etkinlikler_id', 'etkinlikler_id');
    }

    public function sohbetKanaliOlustur($tur)
    {
        return $this->mesajKanal()->create([
            'etkinlikler_id' => $this->etkinlikler_id,
            'baslik'         => $this->baslik,
            'tur'            => $tur,
        ]);
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

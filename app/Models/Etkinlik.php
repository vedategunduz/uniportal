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
        'giden_isletmeler_id',
        'gidilen_isletmeler_id',
        'kod',
        'etkinlikBasvuruTarihi',
        'etkinlikBasvuruBitisTarihi',
        'etkinlikBaslamaTarihi',
        'etkinlikBitisTarihi',
        'kapakResmiYolu',
        'baslik',
        'aciklama',
        'harita',
        'goruntulenmeSayisi',
        'katilimSarti',
        'kontenjan',
        'yorumDurumu',
        'mailDurumu',
        'sosyalMedyadaPaylas',
        'aktiflik',
    ];

    public function katilimcilar()
    {
        return $this->hasMany(EtkinlikKatilim::class, 'etkinlikler_id', 'etkinlikler_id');
    }

    public function gidenKatilimcilar()
    {
        return $this->hasMany(EtkinlikKatilim::class, 'etkinlikler_id', 'etkinlikler_id')->where('katilimciTipi', 'giden');
    }

    public function gidilenKatilimcilar()
    {
        return $this->hasMany(EtkinlikKatilim::class, 'etkinlikler_id', 'etkinlikler_id')->where('katilimciTipi', 'gidilen');
    }

    public function tur()
    {
        return $this->belongsTo(EtkinlikTur::class, 'etkinlik_turleri_id', 'etkinlik_turleri_id');
    }

    public function isletme()
    {
        return $this->belongsTo(Isletme::class, 'isletmeler_id', 'isletmeler_id');
    }

    public function gidenIsletme()
    {
        return $this->belongsTo(Isletme::class, 'giden_isletmeler_id', 'isletmeler_id');
    }

    public function gidilenIsletme()
    {
        return $this->belongsTo(Isletme::class, 'gidilen_isletmeler_id', 'isletmeler_id');
    }

    public function begeni()
    {
        return $this->hasMany(EtkinlikBegeniDetay::class, 'etkinlikler_id', 'etkinlikler_id');
    }

    public function yorum()
    {
        return $this->hasMany(EtkinlikYorum::class, 'etkinlikler_id', 'etkinlikler_id')->where('aktiflik', 1);
    }

    public function resimler()
    {
        return $this->hasMany(EtkinlikDosya::class, 'etkinlikler_id', 'etkinlikler_id');
    }

    public function il()
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

    public function whoIsCreator()
    {
        return $this->belongsTo(Kullanici::class, 'islem_yapan_id', 'kullanicilar_id');
    }

    public function incrementView()
    {
        $this->increment('goruntulenmeSayisi');
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

    public function mesajKanallari() {
        return $this->hasMany(MesajKanal::class, 'etkinlikler_id', 'etkinlikler_id');
    }
}

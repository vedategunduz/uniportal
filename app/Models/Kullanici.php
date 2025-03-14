<?php

namespace App\Models;

use App\IslemYapanTrait;
use App\Mail\Auth\OnayMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

/**
 * @method bool aktifKanal(int $kanalId)
 * @method void setUnipoint(int $point)
 */
class Kullanici extends Authenticatable
{
    use HasFactory, Notifiable, IslemYapanTrait;

    protected $table = 'kullanicilar';

    protected $primaryKey = 'kullanicilar_id';

    protected $fillable = [
        'unvanlar_id',
        'isletmeler_id',
        'isletme_birimleri_id',
        'kod',
        'ad',
        'soyad',
        'email',
        'telefon',
        'dahiliTelefon',
        'adres',
        'profilFotoUrl',
        'password',
        'puan',
        'unipuan',
        'gunlukUnipuan',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function loginHistories()
    {
        return $this->hasMany(LoginHistory::class, 'kullanicilar_id', 'kullanicilar_id');
    }

    public function anaIsletme()
    {
        return $this->belongsTo(Isletme::class, 'isletmeler_id', 'isletmeler_id');
    }

    public function anaUnvan()
    {
        return $this->belongsTo(Unvan::class, 'unvanlar_id');
    }

    public function anaBirim()
    {
        return $this->belongsTo(IsletmeBirim::class, 'isletme_birimleri_id', 'isletme_birimleri_id');
    }

    public function paylasimlar()
    {
        return $this->hasMany(Paylasim::class, 'kullanicilar_id', 'kullanicilar_id')->orderBy('created_at', 'desc');
    }

    public function takipciler()
    {
        return $this->belongsToMany(Kullanici::class, 'kullanici_takip', 'kullanicilar_id', 'takip_eden_id');
    }

    public function takipEdilenler()
    {
        return $this->belongsToMany(Kullanici::class, 'kullanici_takip', 'takip_eden_id', 'kullanicilar_id');
    }

    public static function kullanicilariGetir(array $kullanicilar_id)
    {
        return self::whereIn('kullanicilar_id', $kullanicilar_id)
            ->whereNot('kullanicilar_id', 1)
            ->where('aktiflik', 1)
            ->get();
    }

    public function sonGirisler(int $limit = 3)
    {
        return $this->hasMany(LoginHistory::class, 'kullanicilar_id')
            ->orderBy('created_at', 'desc')
            ->limit($limit);
    }

    public function puanKullan(int $point)
    {
        if ($this->gunlukUnipuan > 0) {
            $this->toplamPuanEkle($point);
            $this->gunlukPuanDus($point);
        }
    }

    public function toplamPuanEkle(int $point)
    {
        $this->unipuan += $point;
        $this->save();
    }

    public function gunlukPuanDus(int $point)
    {
        $this->gunlukUnipuan -= $point;
        $this->save();
    }

    public function isletmeler()
    {
        return $this->hasMany(KullaniciBirimUnvan::class, 'kullanicilar_id', 'kullanicilar_id');
    }

    public function roller()
    {
        return $this->hasMany(KullaniciRolIliski::class, 'kullanicilar_id', 'kullanicilar_id');
    }

    public static function mesajKanallari()
    {
        $kanalIdleri = MesajKanalKatilimci::where('kullanicilar_id', Auth::user()->kullanicilar_id)->pluck('mesaj_kanallari_id')->toArray();
        return MesajKanal::whereIn('mesaj_kanallari_id', $kanalIdleri)->get();
    }

    public static function aktifMesajKanallari()
    {
        $kanalIdleri = MesajKanalKatilimci::where('kullanicilar_id', Auth::user()->kullanicilar_id)->where('aktiflik', 1)->pluck('mesaj_kanallari_id')->toArray();
        return MesajKanal::whereIn('mesaj_kanallari_id', $kanalIdleri)->get();
    }

    public function mesajlar()
    {
        return $this->hasMany(Mesaj::class, 'kullanicilar_id', 'kullanicilar_id');
    }

    public function mesajKanalKatilimcilar()
    {
        return $this->hasMany(MesajKanalKatilimci::class, 'kullanicilar_id');
    }

    public function kanalKontrol($kanalId)
    {
        return $this->mesajKanalKatilimcilar()
            ->where('mesaj_kanallari_id', $kanalId)
            ->exists();
    }

    public function aktifKanal($kanalId)
    {
        return $this->mesajKanalKatilimcilar()
            ->where('mesaj_kanallari_id', $kanalId)
            ->where('aktiflik', 1)
            ->exists();
    }

    public function kanalYoneticisimi($kanalId)
    {
        return $this->mesajKanalKatilimcilar()
            ->where('mesaj_kanallari_id', $kanalId)
            ->where('yoneticilikDurumu', 1)
            ->where('aktiflik', 1)
            ->exists();
    }

    // Bunu evente bağla
    public function sendEmailVerificationNotification()
    {
        Mail::to($this->email)->send(new OnayMail($this));
    }
}

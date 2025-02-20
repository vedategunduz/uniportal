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
 */
class Kullanici extends Authenticatable
{
    use HasFactory, Notifiable, IslemYapanTrait;

    protected $table = 'kullanicilar';

    protected $primaryKey = 'kullanicilar_id';

    protected $fillable = [
        'unvanlar_id',
        'isletmeler_id',
        'ad',
        'soyad',
        'email',
        'telefon',
        'adres',
        'profilFotoUrl',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

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

    public function anaIsletme()
    {
        return $this->belongsTo(Isletme::class, 'isletmeler_id', 'isletmeler_id');
    }

    public function isletme()
    {
        $isletmeler_id = $this->hasMany(IsletmeYetkili::class, 'kullanicilar_id')->pluck('isletmeler_id')->toArray();
        return Isletme::whereIn('isletmeler_id', $isletmeler_id)->get();
    }

    public function anaUnvan()
    {
        return $this->belongsTo(Unvan::class, 'unvanlar_id');
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

    // Bunu evente bağla
    public function sendEmailVerificationNotification()
    {
        Mail::to($this->email)->send(new OnayMail($this));
    }
}

<?php

namespace App\Models;

use App\IslemYapanTrait;
use App\Mail\HesapOnaylamaMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;

class Kullanici extends Authenticatable
{
    use HasFactory, Notifiable, IslemYapanTrait;

    protected $table = 'kullanicilar';

    protected $primaryKey = 'kullanicilar_id';

    protected $fillable = [
        'roller_id',
        'unvanlar_id',
        'ad',
        'soyad',
        'email',
        'telefon',
        'adres',
        'profilFotoUrl',
        'password',
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

    public function isletme()
    {
        $isletmeler_id = $this->hasMany(IsletmeYetkili::class, 'kullanicilar_id')->pluck('isletmeler_id')->toArray();
        return Isletme::whereIn('isletmeler_id', $isletmeler_id)->get();
    }

    public function anaUnvan()
    {
        return $this->belongsTo(Unvan::class, 'unvanlar_id');
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'roller_id');
    }

    public function sendEmailVerificationNotification() {
        Mail::to($this->email)->send(new HesapOnaylamaMail($this));
    }
}

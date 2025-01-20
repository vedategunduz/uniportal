<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Kullanici extends Authenticatable
{
    use HasFactory, Notifiable, IslemYapanTrait;

    protected $table = 'kullanicilar';

    protected $primaryKey = 'kullanicilar_id';

    protected $fillable = [
        'roller_id',
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

    // kullanıcı kayıt olduğu gibi şifresi hashlenir
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function isletme()
    {
        $isletmeler_id = $this->hasMany(IsletmeYetkili::class, 'kullanicilar_id')->pluck('isletmeler_id')->toArray();
        return Isletme::whereIn('isletmeler_id', $isletmeler_id)->get();
    }

    // // Gereksiz herhalde
    // public function YetkiliOlduguIsletmeler()
    // {
    //     return $this->hasMany(IsletmeYetkili::class, 'kullanicilar_id');
    // }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'roller_id');
    }
}

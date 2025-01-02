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

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function YetkiliOlduguIsletmeler(){
        return $this->hasMany(IsletmeYetkili::class, 'kullanicilar_id');
    }

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'roller_id');
    }
}

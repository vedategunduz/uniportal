<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Isletme extends Model
{
    use HasFactory, IslemYapanTrait;

    protected $table = 'isletmeler';

    protected $primaryKey = 'isletmeler_id';

    protected $fillable = [
        'isletme_turleri_id',
        'iller_id',
        'referans_kodu',
        'referans',
        'baslik',
        'adres',
        'logoUrl',
        'websiteUrl',
        'xUrl',
        'instagramUrl',
        'linkedinUrl',
        'digerUrl',
        'aktiflik',
    ];

    public static function referans_kodu($isletmeler_id) {
        return self::where('isletmeler_id', $isletmeler_id)->value('referans_kodu');
    }
}

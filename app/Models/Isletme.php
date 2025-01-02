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
}

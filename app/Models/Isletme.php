<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Isletme extends Model
{
    use HasFactory;

    protected $table = 'isletmeler';

    protected $primaryKey = 'isletmeler_id';

    protected $fillable = [
        'isletme_turleri_id',
        'iller_id',
        'referans_kodu',
        'baslik',
        'adres',
        'logoUrl',
        'websiteUrl',
        'xUrl',
        'instagramUrl',
        'linkedinUrl',
        'digerUrl',
        'aktiflik',
        'islem_yapan_id',
    ];
}

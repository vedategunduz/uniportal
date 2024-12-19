<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Yorum extends Model
{
    /** @use HasFactory<\Database\Factories\YorumlarFactory> */
    use HasFactory;

    protected $table = 'yorumlar';

    protected $primaryKey = 'yorumlar_id';

    protected $fillable = [
        'firmalar_id',
        'kullanicilar_id',
        'kamular_id',
        'etkinlikler_id',
        'firma_hizmetleri_id',
        'kamu_hizmetleri_id',
        'aciklama',
        'puan',
    ];

    public $timestamps = true;
}

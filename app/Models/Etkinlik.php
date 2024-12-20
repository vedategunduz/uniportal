<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etkinlik extends Model
{
    /** @use HasFactory<\Database\Factories\EtkinlikFactory> */
    use HasFactory;

    protected $table = 'etkinlikler';

    protected $primaryKey = 'etkinlikler_id';

    protected $fillable = [
        'etkinlik_tur_id',
        'firmalar_id',
        'kamular_id',
        'etkinlik_basvuru_tarihi',
        'etkinlik_basvuru_bitis_tarihi',
        'etkinlik_baslama_tarihi',
        'etkinlik_bitis_tarihi',
        'aciklama',
    ];

    public $timestamps = true;
}

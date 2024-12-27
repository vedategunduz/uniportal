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
        'etkinlik_turleri_id',
        'isletmeler_id',
        'etkinlikBasvuruTarihi',
        'etkinlikBasvuruBitisTarihi',
        'etkinlikBaslamaTarihi',
        'etkinlikBitisTarihi',
        'kontenjan',
        'yorumDurumu',
        'aciklama',
        'islem_yapan_id',
    ];
}

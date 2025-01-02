<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Yorum extends Model
{
    /** @use HasFactory<\Database\Factories\YorumlarFactory> */
    use HasFactory, IslemYapanTrait;

    protected $table = 'yorumlar';

    protected $primaryKey = 'yorumlar_id';

    protected $fillable = [
        'kullanicilar_id',
        'isletmeler_id',
        'etkinlikler_id',
        'hizmetler_id',
        'aciklama',
        'puan',
    ];
}

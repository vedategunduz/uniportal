<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtkinlikKatilim extends Model
{
    /** @use HasFactory<\Database\Factories\EtkinlikKatilimFactory> */
    use HasFactory;

    protected $table = 'etkinlik_katilimlari';

    protected $primaryKey = 'etkinlik_katilimlari_id';

    protected $fillable = [
        'etkinlikler_id',
        'kullanicilar_id',
        'firmalar_id',
        'kamular_id',
        'durum',
        'islem_yapan_id',
    ];

    // Durum ENUM => ['beklemede', 'onaylandi', 'iptal']

    public $timestamps = true;
}

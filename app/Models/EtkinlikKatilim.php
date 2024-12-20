<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtkinlikKatilim extends Model
{
    /** @use HasFactory<\Database\Factories\EtkinlikKatilimFactory> */
    use HasFactory;

    protected $table = 'etkinlik_katimlari';

    protected $primaryKey = 'etkinlik_katimlari_id';

    protected $fillable = [
        'etkinlikler_id',
        'kullanicilar_id',
        'firmalar_id',
        'kamular_id',
        'durum',
    ];

    public $timestamps = true;
}

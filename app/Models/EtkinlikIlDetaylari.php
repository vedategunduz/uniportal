<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtkinlikIlDetaylari extends Model
{
    use HasFactory, IslemYapanTrait;
    protected $table = 'etkinlik_il_detaylari';

    protected $primaryKey = 'etkinlik_il_detaylari_id';

    protected $fillable = [
        'etkinlikler_id',
        'iller_id',
        'yapilanIslem',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EtkinlikIlDetaylari extends Model
{
    use HasFactory;
    protected $table = 'etkinlik_il_detaylari';

    protected $primaryKey = 'etkinlik_il_detaylari_id';

    protected $fillable = [
        'etkinlikler_id',
        'iller_id',
        'islem_yapan_id',
    ];
}
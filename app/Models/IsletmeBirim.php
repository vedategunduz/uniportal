<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IsletmeBirim extends Model
{

    protected $table = "isletme_birimleri";

    protected $primaryKey = "isletme_birimleri_id";

    protected $fillabel = [
        'isletmeler_id',
        'birim_tipleri_id',
        'birimAd',
        'birimTelefon',
        'birimEmail',
        'birimWebsiteUrl',
        'birimAdres',
    ];
}

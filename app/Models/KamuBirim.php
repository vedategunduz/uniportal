<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KamuBirim extends Model
{

    protected $table = "kamu_birimleri";

    protected $primaryKey = "kamu_birimleri_id";

    protected $fillabel = [
        'kamular_id',
        'birim_tipleri_id',
        'birim_ad',
        'birim_telefon',
        'birim_email',
        'birim_website_url',
        'birim_adres',
    ];

    public $timestamps = true;
}

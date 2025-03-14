<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Model;

class IsletmeBirim extends Model
{
    use IslemYapanTrait;

    protected $table = "isletme_birimleri";

    protected $primaryKey = "isletme_birimleri_id";

    protected $fillable = [
        'isletmeler_id',
        'birim_tipleri_id',
        'baslik',
    ];
}

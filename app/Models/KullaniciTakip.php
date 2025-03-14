<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Model;

class KullaniciTakip extends Model
{
    use IslemYapanTrait;

    protected $table = 'kullanici_takip';

    protected $primaryKey = 'kullanici_takip_id';

    protected $fillable = [
        'kullanicilar_id',
        'takip_eden_id',
        'durum',
    ];
}

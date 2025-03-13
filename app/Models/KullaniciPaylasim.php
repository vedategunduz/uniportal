<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Model;

class KullaniciPaylasim extends Model
{
    use IslemYapanTrait;

    protected $table = 'kullanici_paylasimlar';

    protected $primaryKey = 'kullanici_paylasimlar_id';

    protected $fillable = [
        'kullanicilar_id',
        'aciklama',
        'kapakFotoUrl',
    ];
}

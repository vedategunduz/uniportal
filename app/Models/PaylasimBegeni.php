<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Model;

class PaylasimBegeni extends Model
{
    use IslemYapanTrait;

    protected $table = 'paylasim_begeniler';

    protected $primaryKey = 'paylasim_begeniler_id';

    protected $fillable = [
        'paylasimlar_id',
        'kullanicilar_id',
        'aktiflik',
    ];
}

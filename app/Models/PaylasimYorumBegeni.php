<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Model;

class PaylasimYorumBegeni extends Model
{
    use IslemYapanTrait;

    protected $table = 'paylasim_yorum_begeniler';
    protected $primaryKey = 'paylasim_yorum_begeniler_id';

    protected $fillable = [
        'kullanicilar_id',
        'paylasim_yorumlari_id',
    ];
}

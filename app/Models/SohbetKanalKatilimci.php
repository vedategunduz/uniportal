<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Model;

class SohbetKanalKatilimci extends Model
{
    use IslemYapanTrait;

    protected $table = 'sohbet_kanal_katilimcilari';

    protected $primaryKey = 'sohbet_kanal_katilimcilari_id';

    protected $fillable = [
        'sohbet_kanallari_id',
        'kullanicilar_id',
    ];
}

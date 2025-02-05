<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Model;

class SohbetKanal extends Model
{
    use IslemYapanTrait;

    protected $table = 'sohbet_kanallari';

    protected $primaryKey = 'sohbet_kanallari_id';

    protected $fillable = [
        'etkinlikler_id',
        'baslik',
        'resim',
        'tur',
        'aktiflik',
    ];
}

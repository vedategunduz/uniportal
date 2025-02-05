<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Model;

class EtkinlikMesaj extends Model
{
    use IslemYapanTrait;

    protected $table = 'mesajlar';

    protected $primaryKey = 'mesajlar_id';

    protected $fillable = [
        'sohber_kanallari_id',
        'kullanicilar_id',
        'mesaj',
        'durum',
    ];
}

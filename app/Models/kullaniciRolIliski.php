<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Model;

class KullaniciRolIliski extends Model
{
    use IslemYapanTrait;

    protected $table = 'kullanici_rol_iliskileri';

    protected $primaryKey = 'kullanici_rol_iliskileri_id';

    protected $fillable = [
        'kullanicilar_id',
        'roller_id',
        'aktiflik'
    ];
}

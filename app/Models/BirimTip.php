<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BirimTip extends Model
{
    use HasFactory, IslemYapanTrait;

    protected $table = 'birim_tipleri';

    protected $primaryKey = 'birim_tipleri_id';

    protected $fillable = [
        'isletme_turleri_id',
        'baslik',
    ];

    public static function birimTurleriGetir()
    {
        return self::where('aktiflik', 1)->get();
    }
}

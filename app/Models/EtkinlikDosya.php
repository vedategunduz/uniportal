<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Model;

class EtkinlikDosya extends Model
{
    use IslemYapanTrait;

    protected $table = 'etkinlik_dosyalar';

    protected $primaryKey = 'etkinlik_dosyalar_id';

    protected $fillable = [
        'etkinlikler_id',
        'dosya_adi',
        'dosya_yolu',
    ];

    public function etkinlik()
    {
        return $this->belongsTo(Etkinlik::class, 'etkinlikler_id', 'etkinlikler_id');
    }
}

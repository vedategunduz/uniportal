<?php

namespace App\Models;

use App\IslemYapanTrait;
use Illuminate\Database\Eloquent\Model;

class EtkinlikTur extends Model
{
    use IslemYapanTrait;

    protected $table = 'etkinlik_turleri';

    protected $primaryKey = 'etkinlik_turleri_id';

    protected $fillable = [
        'baslik',
        'class',
    ];
}
